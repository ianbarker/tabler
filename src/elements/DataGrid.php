<?php

namespace eznio\tabler\elements;


use eznio\ar\Ar;
use eznio\tabler\traits\StyleAware;

/**
 * Overall dara grid-representing rendering element
 * @package eznio\tabler\elements
 */
class DataGrid extends Element
{
    use StyleAware;

    /** @var array  */
    private $data = [];

    /**
     * Adds another row to data set
     * @param DataRow $row
     * @return $this
     */
    public function addRow(DataRow $row)
    {
        $this->data[$row->getId()] = $row;
        return $this;
    }

    /**
     * Returns row by its ID or NULL if no rows found
     * @param $rowId
     * @return DataRow|null
     */
    public function getRow($rowId)
    {
        return Ar::get($this->data, $rowId);
    }

    /**
     * Returns all rows
     * @return array
     */
    public function getRows()
    {
        return $this->data;
    }
}
