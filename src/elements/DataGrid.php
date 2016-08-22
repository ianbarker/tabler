<?php

namespace eznio\tabler\elements;


use eznio\ar\Ar;
use eznio\tabler\traits\StyleAware;

class DataGrid extends Element
{
    use StyleAware;

    private $data = [];

    public function addRow(DataRow $row)
    {
        $this->data[$row->getId()] = $row;
        return $this;
    }

    /**
     * @param $rowId
     * @return DataRow|null
     */
    public function getRow($rowId)
    {
        return Ar::get($this->data, $rowId);
    }

    public function getRows()
    {
        return $this->data;
    }
}
