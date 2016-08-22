<?php

namespace eznio\tabler\traits;

/**
 * MaxLengthAware trait adds maxLength property and its getter/setter
 * @package eznio\tabler\traits
 */
trait MaxLengthAware
{
    /** @var int */
    protected $maxLength = 0;

    /**
     * @return int
     */
    public function getMaxLength()
    {
        return $this->maxLength;
    }

    /**
     * @param int $maxLength
     * @return $this
     */
    public function setMaxLength($maxLength)
    {
        $this->maxLength = (int) $maxLength;
        return $this;
    }
}
