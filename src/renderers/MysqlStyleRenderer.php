<?php

namespace eznio\tabler\renderers;


use eznio\tabler\elements\DataCell;
use eznio\tabler\elements\HeaderCell;
use eznio\tabler\elements\TableLayout;
use eznio\tabler\elements\TextElement;
use eznio\tabler\helpers\Styler;
use eznio\tabler\interfaces\Renderer;
use eznio\tabler\elements\DataRow;

/**
 * Mysql-style table renderer
 *
 * Example:
 * <pre>
 * +-----------+-----------+
 * | Column 1  | Column 2  |
 * +-----------+-----------+
 * | Value 1-1 | Value 2-1 |
 * | Value 1-2 | Value 2-2 |
 * | Value 1-3 | Value 2-3 |
 * +-----------+-----------+
 * </pre>
 *
 * @package eznio\tabler\renderers
 */
class MysqlStyleRenderer implements Renderer
{
    const VERTICAL_LINE = '|';
    const HORIZONTAL_LINE = '-';
    const CROSSING = '+';

    const PADDING_LEFT = 1;
    const PADDING_RIGHT = 1;

    const DEFAULT_TEXT_ALIGNMENT = STR_PAD_RIGHT;
    const DEFAULT_HEADER_ALIGNMENT = STR_PAD_BOTH;

    /** @var TableLayout */
    protected $tableLayout;

    /**
     * Renders the whole table
     * @param TableLayout $tableLayout
     * @return string
     */
    public function render(TableLayout $tableLayout)
    {
        $this->tableLayout = $tableLayout;
        $result = [];

        $result[] = $this->renderSeparator();
        $result[] = $this->renderHeaderLine();
        $result[] = $this->renderSeparator();
        $result = array_merge($result, $this->renderDataGrid());
        $result[] = $this->renderSeparator();

        return implode(PHP_EOL, $result) . PHP_EOL;
    }

    /**
     * Renders separator row
     * @return string
     */
    protected function renderSeparator()
    {
        $result = '';

        $result .= self::CROSSING;
        foreach ($this->tableLayout->getHeaderLine()->getHeaderCells() as $header) {
            /** @var HeaderCell $header */
            $result .=
                str_repeat(self::HORIZONTAL_LINE, $header->getMaxLength() + self::PADDING_LEFT + self::PADDING_RIGHT)
                . self::CROSSING;

        }

        if (0 < count($this->tableLayout->getStyles())) {
            $result .= Styler::getReset();
        }

        return $this->addStyles($result, $this->tableLayout->getStyles());
    }

    /**
     * Renders heading
     * @return string
     */
    protected function renderHeaderLine()
    {
        $result = $this->addStyles(self::VERTICAL_LINE, $this->tableLayout->getStyles());

        foreach ($this->tableLayout->getHeaderLine()->getHeaderCells() as $header) {
            /** @var HeaderCell $header */
            $result .=  $this->addStyles(' '
                . str_pad($header->getTitle(), $header->getMaxLength(), ' ', self::DEFAULT_HEADER_ALIGNMENT)
                . ' ',
                array_merge($this->tableLayout->getHeaderLine()->getStyles(), $header->getStyles())
            );
            $result .= $this->addStyles(self::VERTICAL_LINE, $this->tableLayout->getStyles());
        }
        return $result;
    }

    /**
     * Renders single data row
     * @param DataRow $row
     * @return string
     */
    protected function renderDataRow(DataRow $row)
    {
        $result = $this->addStyles(self::VERTICAL_LINE, $this->tableLayout->getStyles());

        foreach ($row->getCells() as $cell) {
            /** @var DataCell $cell */
            $result .=  $this->addStyles(' '
                . str_pad($cell->getData(), $cell->getMaxLength(), ' ', $this->getCellTextAlignment($cell))
                . ' ',
                array_merge($row->getStyles(), $cell->getStyles())
            );
            $result .= $this->addStyles(self::VERTICAL_LINE, $this->tableLayout->getStyles());
        }
        return $result;
    }

    /**
     * Renders whole data grid
     * @return array
     */
    protected function renderDataGrid()
    {
        $result = [];
        foreach ($this->tableLayout->getDataGrid()->getRows() as $row) {
            $result[] = $this->renderDataRow($row);
        }
        return $result;
    }

    /**
     * Adds style/reset-style escape sequences to element
     * @param string $element element to add styles to
     * @param array $styles array of style constants
     * @return string
     */
    protected function addStyles($element, $styles)
    {
        if (0 < count($styles)) {
            return Styler::get($styles) . $element . Styler::getReset();
        }
        return $element;
    }

    protected function getCellTextAlignment(DataCell $cell)
    {
        $cellId = $cell->getId();
        $columnAlignment = $this->tableLayout->getHeaderLine()->getHeaderCell($cellId)->getTextAlignment();
        $cellAlignment = $cell->getTextAlignment();

        $alignment = self::DEFAULT_TEXT_ALIGNMENT;
        if (TextElement::TEXT_ALIGN_INHERIT !== $columnAlignment) {
            $alignment = $columnAlignment;
        }
        if (TextElement::TEXT_ALIGN_INHERIT !== $cellAlignment) {
            $alignment = $cellAlignment;
        }

        return $alignment;
    }
}
