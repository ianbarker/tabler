<?php

namespace eznio\tabler\elements;


use eznio\tabler\traits\MaxLengthAware;
use eznio\tabler\traits\StyleAware;

/**
 * Total line's single cell-representing rendering element
 * @package eznio\tabler\elements
 */
class TotalCell extends Element
{
    use StyleAware, MaxLengthAware;

    /** @var string */
    protected $title = '';

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return HeaderCell
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }
}
