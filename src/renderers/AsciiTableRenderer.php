<?php

namespace eznio\tabler\renderers;


use eznio\ar\Ar;
use eznio\tabler\elements\DataCell;
use eznio\tabler\elements\HeaderCell;
use eznio\tabler\elements\TableLayout;
use eznio\tabler\helpers\Styler;
use eznio\tabler\interfaces\Renderer;
use eznio\tabler\elements\DataRow;
use eznio\tabler\references\Defaults;
use eznio\tabler\references\TextAlignments;

/**
 * @package eznio\tabler\renderers
 */
abstract class AsciiTableRenderer implements Renderer
{
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

        $result[] = $this->renderTopSeparator();
        $result[] = $this->renderHeaderLine();
        $result[] = $this->renderMiddleSeparator();
        $result = array_merge($result, $this->renderDataGrid());
        $result[] = $this->renderBottomSeparator();

        $result = Ar::filter($result, function ($item) {
            return strlen($item) > 0;
        });

        return implode(PHP_EOL, $result) . PHP_EOL;
    }

    /**
     * Renders table heading top line
     * @return string
     */
    protected function renderTopSeparator()
    {
        return $this->renderSeparator(
            $this->getTopLeftSymbol(),
            $this->getTopCrossingSymbol(),
            $this->getTopRightSymbol()
        );
    }

    /**
     * Renders table heading top line
     * @return string
     */
    protected function renderMiddleSeparator()
    {
        return $this->renderSeparator(
            $this->getMiddleLeftSymbol(),
            $this->getMiddleCrossingSymbol(),
            $this->getMiddleRightSymbol()
        );
    }

    /**
     * Renders table heading top line
     * @return string
     */
    protected function renderBottomSeparator()
    {
        return $this->renderSeparator(
            $this->getBottomLeftSymbol(),
            $this->getBottomCrossingSymbol(),
            $this->getBottomRightSymbol()
        );
    }

    /**
     * Renders separator row
     * @param $leftSymbol
     * @param $crossingSymbol
     * @param $rightSymbol
     * @return string
     */
    protected function renderSeparator($leftSymbol, $crossingSymbol, $rightSymbol)
    {
        $result = '';

        $result .= $leftSymbol;
        foreach ($this->tableLayout->getHeaderLine()->getHeaderCells() as $header) {
            /** @var HeaderCell $header */
            $result .=
                str_repeat(
                    $this->getHorizontalSymbol(),
                    $header->getLength() + $header->getLeftPadding() + $header->getRightPadding()
                )
                . ($header->getIsLast() ? $rightSymbol : $crossingSymbol);

        }
        //$result[strlen($result) - 1] = $rightSymbol;

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
        $result = $this->addStyles($this->getVerticalSymbol(), $this->tableLayout->getStyles());

        foreach ($this->tableLayout->getHeaderLine()->getHeaderCells() as $headerCell) {
            /** @var HeaderCell $headerCell */
            $result .=  $this->addStyles(
                $this->renderHeaderCell($headerCell),
                array_merge($this->tableLayout->getHeaderLine()->getStyles(), $headerCell->getStyles())
            );
            $result .= $this->addStyles($this->getVerticalSymbol(), $this->tableLayout->getStyles());
        }
        return $result;
    }

    /**
     * Renders single header cell with applicable paddings
     * @param $headerCell
     * @return string
     */
    protected function renderHeaderCell(HeaderCell $headerCell)
    {
        return str_pad(
            '',
            $headerCell->getLeftPadding(),
            ' '
        ) .
        str_pad(
            $headerCell->getTitle(),
            $headerCell->getLength(),
            ' ',
            Defaults::HEADER_ALIGNMENT
        ) .
        str_pad(
            '',
            $headerCell->getRightPadding(),
            ' '
        );
    }

    /**
     * Renders single data row
     * @param DataRow $row
     * @return string
     */
    protected function renderDataRow(DataRow $row)
    {
        $result = $this->addStyles($this->getVerticalSymbol(), $this->tableLayout->getStyles());

        foreach ($row->getCells() as $cell) {
            /** @var DataCell $cell */
            $result .=  $this->addStyles(
                $this->renderDataCell($cell),
                array_merge($row->getStyles(), $cell->getStyles())
            );
            $result .= $this->addStyles($this->getVerticalSymbol(), $this->tableLayout->getStyles());
        }
        return $result;
    }

    /**
     * Renders single data row cell contents with applicable paddings
     * @param DataCell $cell
     * @return string
     */
    protected function renderDataCell(DataCell $cell)
    {
        return str_repeat(
            ' ',
            $cell->getLeftPadding()
        ) .
        str_pad(
            $cell->getData(),
            $cell->getLength(), ' ', $this->getCellTextAlignment($cell)
        ) .
        str_repeat(
            ' ',
            $cell->getRightPadding()
        );
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

        $alignment = Defaults::TEXT_ALIGNMENT;
        if (TextAlignments::TEXT_ALIGN_INHERIT !== $columnAlignment) {
            $alignment = $columnAlignment;
        }
        if (TextAlignments::TEXT_ALIGN_INHERIT !== $cellAlignment) {
            $alignment = $cellAlignment;
        }

        return $alignment;
    }

    abstract public function getTopLeftSymbol();
    abstract public function getTopCrossingSymbol();
    abstract public function getTopRightSymbol();

    abstract public function getMiddleLeftSymbol();
    abstract public function getMiddleCrossingSymbol();
    abstract public function getMiddleRightSymbol();

    abstract public function getBottomLeftSymbol();
    abstract public function getBottomCrossingSymbol();
    abstract public function getBottomRightSymbol();

    abstract public function getHorizontalSymbol();
    abstract public function getVerticalSymbol();
}
