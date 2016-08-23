<?php

namespace eznio\tabler\elements;


/**
 * Data cell rendering element
 * @package eznio\tabler\elements
 */
class DataCell extends Cell
{
    /** @var string|null */
    protected $data = null;

    /**
     * Returns cell value
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Sets cell value
     * @param mixed $data
     * @return DataCell
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }
}
