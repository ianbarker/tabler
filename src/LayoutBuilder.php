<?php

namespace eznio\tabler;


use eznio\tabler\elements\DataRow;
use eznio\tabler\elements\TableLayout;
use eznio\ar\Ar;

/**
 * LayoutBuilder takes headers/data arrays and builds TableLayout structure
 * @package eznio\tabler
 */
class LayoutBuilder
{
    /**
     * Builds HeaderLine element - header representation
     * @param Composer $composer
     * @return elements\HeaderLine
     */
    public function buildHeadersLine(Composer $composer)
    {
        $headersLine = ElementsFactory::headerLine();
        $headers = $composer->getHeaders();
        $headersCount = count($headers);
        Ar::each($headers, function($header, $headerId) use ($headersLine, $composer, $headersCount) {
            $headersLine->addHeaderCell(
                $headerId,
                ElementsFactory::headerCell()
                    ->setId($headerId)
                    ->setTitle($header)
                    ->setMaxLength(Ar::get($composer->getColumnMaxLengths(), $headerId))
                    ->setIsFirst(0 === count($headersLine->getHeaderCells()))
                    ->setIsLast(count($headersLine->getHeaderCells()) + 1 === $headersCount)
            );
        });
        return $headersLine;
    }

    /**
     * Builds DataGrid element - data table representation
     * @param Composer $composer
     * @return elements\DataGrid
     */
    public function buildDataGrid(Composer $composer)
    {
        $dataGrid = ElementsFactory::dataGrid();
        $data = array_values($composer->getData());
        Ar::each($data, function($row, $key) use ($dataGrid, $composer) {
            $dataRow = ElementsFactory::dataRow()
                ->setId($key)
                ->setOrder($key % 2 === 0 ? DataRow::ORDER_EVEN : DataRow::ORDER_ODD);
            $dataCellsCount = count($row);
            Ar::each($row, function($cell, $cellId) use ($dataRow, $composer, $dataCellsCount) {
                $dataRow->addCell(ElementsFactory::dataCell()
                    ->setId($cellId)
                    ->setData($cell)
                    ->setMaxLength(Ar::get($composer->getColumnMaxLengths(), $cellId))
                    ->setIsFirst(0 === count($dataRow->getCells()))
                    ->setIsLast(count($dataRow->getCells()) + 1 === $dataCellsCount)
                );
            });
            $dataGrid->addRow($dataRow);
        });
        return $dataGrid;
    }

    /**
     * Builds whole table layout
     * @param Composer $composer
     * @param array $styles
     * @return TableLayout
     */
    public function buildTableLayout(Composer $composer, $styles = [])
    {
        $table = new TableLayout();
        $table->setStyles($styles);

        $table->setHeaderLine($this->buildHeadersLine($composer));
        $table->setDataGrid($this->buildDataGrid($composer));

        return $table;
    }
}
