<?php

namespace eznio\tabler\elements;


use eznio\styler\traits\StyleAware;

/**
 * Table layout description for further rendering
 * @package eznio\tabler\elements
 */
class TableLayout
{
    use StyleAware;

    /** @var  HeaderLine */
    protected $headerLine;

    /** @var  DataGrid */
    protected $dataGrid;

    /** @var  TotalLine */
    protected $totalLine;

    /**
     * Set HeaderLine (object representing table headers)
     * @param HeaderLine $headerLine
     * @return $this
     */
    public function setHeaderLine(HeaderLine $headerLine)
    {
        $this->headerLine = $headerLine;
        return $this;
    }

    /**
     * Get HeaderLine (object representing table headers)
     * @return HeaderLine
     */
    public function getHeaderLine()
    {
        return $this->headerLine;
    }

    /**
     * Set DataGrid (object representing table data)
     * @param DataGrid $dataGrid
     * @return $this
     */
    public function setDataGrid(DataGrid $dataGrid)
    {
        $this->dataGrid = $dataGrid;
        return $this;
    }

    /**
     * Get DataGrid (object representing table data)
     * @return DataGrid
     */
    public function getDataGrid()
    {
        return $this->dataGrid;
    }

    /**
     * Set TotalLine (object representing bottom summary line)
     * @param TotalLine $totalLine
     * @return $this
     */
    public function setTotalLine(TotalLine $totalLine)
    {
        $this->totalLine = $totalLine;
        return $this;
    }

    /**
     * Get TotalLine (object representing bottom summary line)
     * @return TotalLine
     */
    public function getTotalLine()
    {
        return $this->totalLine;
    }
}
