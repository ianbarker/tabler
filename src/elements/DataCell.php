<?php

namespace eznio\tabler\elements;


use eznio\tabler\traits\StyleAware;

class DataCell extends Element
{
    use StyleAware;

    protected $data;
    protected $maxLength;

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     * @return DataCell
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMaxLength()
    {
        return $this->maxLength;
    }

    /**
     * @param mixed $maxLength
     * @return DataCell
     */
    public function setMaxLength($maxLength)
    {
        $this->maxLength = $maxLength;
        return $this;
    }
}
