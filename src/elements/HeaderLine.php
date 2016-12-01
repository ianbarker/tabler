<?php

namespace eznio\tabler\elements;


use eznio\ar\Ar;
use eznio\styler\traits\StyleAware;

/**
 * Heading line-representing rendering element
 * @package eznio\tabler\elements
 */
class HeaderLine extends Element
{
    use StyleAware;

    /** @var array */
    protected $headers = [];

    /**
     * Set header cells
     * @param array $headers
     * @return $this
     */
    public function setHeaderCells(array $headers)
    {
        $this->headers = $headers;
        return $this;
    }

    /**
     * Get header cells
     * @return array
     */
    public function getHeaderCells()
    {
        return $this->headers;
    }

    /**
     * Add single header cell
     * @param $columnId
     * @param HeaderCell $value
     */
    public function addHeaderCell($columnId, HeaderCell $value)
    {
        $this->headers[$columnId] = $value;
    }

    /**
     * Get single header cell
     * @param $columnId
     * @return HeaderCell|null
     */
    public function getHeaderCell($columnId)
    {
        return Ar::get($this->headers, $columnId);
    }
}
