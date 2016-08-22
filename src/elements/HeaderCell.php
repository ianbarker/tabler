<?php

namespace eznio\tabler\elements;


use eznio\tabler\traits\MaxLengthAware;
use eznio\tabler\traits\StyleAware;

/**
 * Header row cell-representing rendering element
 * @package eznio\tabler\elements
 */
class HeaderCell extends TextElement
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
