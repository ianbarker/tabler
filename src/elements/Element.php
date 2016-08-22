<?php

namespace eznio\tabler\elements;

/**
 * Abstract rendering element
 * @package eznio\tabler\elements
 */
abstract class Element
{
    /** @var string */
    protected $id = null;

    /**
     * Set element ID
     * @param $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Get element ID
     * @return string|null
     */
    public function getId()
    {
        return $this->id;
    }
}
