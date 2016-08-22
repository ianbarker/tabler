<?php

namespace eznio\tabler;


use eznio\tabler\elements\TableLayout;
use eznio\ar\Ar;

class LayoutBuilder
{
    public function buildHeadersLine(Composer $composer)
    {
        $headersLine = ElementsFactory::headerLine();
        $headers = $composer->getHeaders();
        Ar::each($headers, function($header, $headerId) use ($headersLine, $composer) {
            $headerColumn = ElementsFactory::headerCell()
                ->setId($headerId)
                ->setTitle($header)
                ->setMaxLength(Ar::get($composer->getColumnMaxLengths(), $headerId));
            $headersLine->addHeader($headerId, $headerColumn);
        });
        return $headersLine;
    }

    public function buildDataGrid(Composer $composer)
    {
        $dataGrid = ElementsFactory::dataGrid();
        Ar::each($composer->getData(), function($row, $key) use ($dataGrid, $composer) {
            $dataRow = ElementsFactory::dataRow()
                ->setId($key);
            Ar::each($row, function($cell, $cellId) use ($dataRow, $composer) {
                $dataRow->addCell(ElementsFactory::dataCell()
                    ->setId($cellId)
                    ->setData($cell)
                    ->setMaxLength(Ar::get($composer->getColumnMaxLengths(), $cellId))
                );
            });
            $dataGrid->addRow($dataRow);
        });
        return $dataGrid;
    }

    public function buildTableLayout(Composer $composer, $styles = [])
    {
        $table = new TableLayout();
        $table->setStyles($styles);

        $table->setHeaderLine($this->buildHeadersLine($composer));
        $table->setDataGrid($this->buildDataGrid($composer));

        return $table;
    }
}
