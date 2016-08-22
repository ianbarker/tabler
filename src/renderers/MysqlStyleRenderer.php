<?php

namespace eznio\tabler\renderers;


use eznio\tabler\elements\DataCell;
use eznio\tabler\elements\HeaderCell;
use eznio\tabler\elements\TableLayout;
use eznio\tabler\helpers\Styler;
use eznio\tabler\interfaces\Renderer;
use eznio\tabler\elements\DataRow;

class MysqlStyleRenderer implements Renderer
{
    const VERTICAL_LINE = '|';
    const HORIZONTAL_LINE = '-';
    const CROSSING = '+';

    const PADDING_LEFT = 1;
    const PADDING_RIGHT = 1;

    /** @var TableLayout */
    protected $tableLayout;

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

    protected function renderSeparator()
    {
        $result = '';

        $result .= self::CROSSING;
        foreach ($this->tableLayout->getHeaderLine()->getHeaders() as $header) {
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

    protected function renderHeaderLine()
    {
        $result = $this->addStyles(self::VERTICAL_LINE, $this->tableLayout->getStyles());

        foreach ($this->tableLayout->getHeaderLine()->getHeaders() as $header) {
            /** @var HeaderCell $header */
            $result .=  $this->addStyles(' '
                . str_pad($header->getTitle(), $header->getMaxLength(), ' ', STR_PAD_BOTH)
                . ' ',
                array_merge($this->tableLayout->getHeaderLine()->getStyles(), $header->getStyles())
            );
            $result .= $this->addStyles(self::VERTICAL_LINE, $this->tableLayout->getStyles());
        }
        return $result;
    }

    protected function renderDataRow(DataRow $row)
    {
        $result = $this->addStyles(self::VERTICAL_LINE, $this->tableLayout->getStyles());

        foreach ($row->getCells() as $cell) {
            /** @var DataCell $cell */
            $result .=  $this->addStyles(' '
                . str_pad($cell->getData(), $cell->getMaxLength(), ' ', STR_PAD_RIGHT)
                . ' ',
                array_merge($row->getStyles(), $cell->getStyles())
            );
            $result .= $this->addStyles(self::VERTICAL_LINE, $this->tableLayout->getStyles());
        }
        return $result;
    }

    protected function renderDataGrid()
    {
        $result = [];
        foreach ($this->tableLayout->getDataGrid()->getRows() as $row) {
            $result[] = $this->renderDataRow($row);
        }
        return $result;
    }

    private function addStyles($element, $styles)
    {
        if (0 < count($styles)) {
            return Styler::get($styles) . $element . Styler::getReset();
        }
        return $element;
    }
}
