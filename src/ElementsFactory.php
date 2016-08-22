<?php

namespace eznio\tabler;


use eznio\tabler\elements\DataCell;
use eznio\tabler\elements\DataGrid;
use eznio\tabler\elements\HeaderCell;
use eznio\tabler\elements\DataRow;
use eznio\tabler\elements\HeaderLine;
use eznio\tabler\elements\TotalCell;
use eznio\tabler\elements\TotalLine;

/**
 * Factory to create different rendering elements
 * @package eznio\tabler
 */
class ElementsFactory
{
    /**
     * @return HeaderLine
     */
    public static function headerLine()
    {
        return new HeaderLine();
    }

    /**
     * @return HeaderCell
     */
    public static function headerCell()
    {
        return new HeaderCell();
    }

    /**
     * @return DataGrid
     */
    public static function dataGrid()
    {
        return new DataGrid();
    }

    /**
     * @return DataRow
     */
    public static function dataRow()
    {
        return new DataRow();
    }

    /**
     * @return DataCell
     */
    public static function dataCell()
    {
        return new DataCell();
    }

    /**
     * @return TotalLine
     */
    public static function totalsLine()
    {
        return new TotalLine();
    }

    /**
     * @return TotalCell
     */
    public static function totalsCell()
    {
        return new TotalCell();
    }
}
