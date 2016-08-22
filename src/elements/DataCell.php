<?php

namespace eznio\tabler\elements;


use eznio\tabler\traits\MaxLengthAware;
use eznio\tabler\traits\StyleAware;

/**
 * Data cell rendering element
 * @package eznio\tabler\elements
 */
class DataCell extends Element
{
    use StyleAware, MaxLengthAware;

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
