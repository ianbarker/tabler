<?php

namespace eznio\tabler\elements;


/**
 * Total line's single cell-representing rendering element
 * @package eznio\tabler\elements
 */
class TotalCell extends Cell
{
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
     * @return TotalCell
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }
}
