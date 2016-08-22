<?php

namespace eznio\tabler\renderers;


use eznio\tabler\elements\DataCell;
use eznio\tabler\elements\HeaderCell;
use eznio\tabler\elements\TableLayout;
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

    public function renderSeparator()
    {
        $result = self::CROSSING;
        foreach ($this->tableLayout->getHeaderLine()->getHeaders() as $header) {
            /** @var HeaderCell $header */
            $result .=
                str_repeat(self::HORIZONTAL_LINE, $header->getMaxLength() + self::PADDING_LEFT + self::PADDING_RIGHT)
                . self::CROSSING;

        }
        return $result;
    }

    public function renderHeaderLine()
    {
        $result = self::VERTICAL_LINE;
        foreach ($this->tableLayout->getHeaderLine()->getHeaders() as $header) {
            /** @var HeaderCell $header */
            $result .= ' '
                . str_pad($header->getTitle(), $header->getMaxLength(), ' ', STR_PAD_BOTH)
                . ' '
                . self::VERTICAL_LINE;
        }
        return $result;
    }

    function renderDataRow(DataRow $row)
    {
        $result = self::VERTICAL_LINE;
        foreach ($row->getCells() as $cell) {
            /** @var DataCell $cell */
            $result .= ' '
                . str_pad($cell->getData(), $cell->getMaxLength(), ' ', STR_PAD_RIGHT)
                . ' '
                . self::VERTICAL_LINE;
        }
        return $result;
    }

    public function renderDataGrid()
    {
        $result = [];
        foreach ($this->tableLayout->getDataGrid()->getRows() as $row) {
            $result[] = $this->renderDataRow($row);
        }
        return $result;
    }
}
