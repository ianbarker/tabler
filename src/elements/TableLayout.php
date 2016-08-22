<?php

namespace eznio\tabler\elements;


use eznio\tabler\traits\StyleAware;

class TableLayout
{
    use StyleAware;

    /** @var  HeaderLine */
    protected $headerLine;

    /** @var  DataGrid */
    protected $dataGrid;

    /** @var  TotalLine */
    protected $totalLine;

    public function setHeaderLine(HeaderLine $headerLine)
    {
        $this->headerLine = $headerLine;
    }

    public function getHeaderLine()
    {
        return $this->headerLine;
    }

    public function setDataGrid(DataGrid $dataGrid)
    {
        $this->dataGrid = $dataGrid;
    }

    public function getDataGrid()
    {
        return $this->dataGrid;
    }

    public function setTotalLine(TotalLine $totalLine)
    {
        $this->totalLine = $totalLine;
    }

    public function getTotalLine()
    {
        return $this->totalLine;
    }
}
