<?php

namespace eznio\tabler\elements;


/**
 * Header row cell-representing rendering element
 * @package eznio\tabler\elements
 */
class HeaderCell extends Cell
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
     * @return HeaderCell
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }
}
