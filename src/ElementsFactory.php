<?php

namespace eznio\tabler;


use eznio\tabler\elements\DataCell;
use eznio\tabler\elements\DataGrid;
use eznio\tabler\elements\HeaderCell;
use eznio\tabler\elements\DataRow;
use eznio\tabler\elements\HeaderLine;
use eznio\tabler\elements\TotalCell;
use eznio\tabler\elements\TotalLine;

class ElementsFactory
{
    public static function headerLine()
    {
        return new HeaderLine();
    }

    public static function headerCell()
    {
        return new HeaderCell();
    }

    public static function dataGrid()
    {
        return new DataGrid();
    }

    public static function dataRow()
    {
        return new DataRow();
    }

    public static function dataCell()
    {
        return new DataCell();
    }

    public static function totalsLine()
    {
        return new TotalLine();
    }

    public static function totalsCell()
    {
        return new TotalCell();
    }
}
