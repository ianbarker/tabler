<?php

namespace eznio\tabler\elements;


use eznio\tabler\traits\StyleAware;

class Cell extends Element
{
    use StyleAware;

    /** @var int */
    protected $maxLength = 0;

    /** @var int */
    protected $minLength = 0;

    /** @var int */
    private $textAlignment = null;

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

    /**
     * @return int
     */
    public function getMinLength()
    {
        return $this->minLength;
    }

    /**
     * @param int $minLength
     * @return $this
     */
    public function setMinLength($minLength)
    {
        $this->minLength = (int) $minLength;
        return $this;
    }

    /**
     * @return int
     */
    public function getTextAlignment()
    {
        return $this->textAlignment;
    }

    /**
     * @param int $textAlignment
     * @return $this
     */
    public function setTextAlignment($textAlignment)
    {
        $this->textAlignment = $textAlignment;
        return $this;
    }

    /**
     * @return int
     */
    public function getLength()
    {
        return $this->getMaxLength() < $this->getMinLength() ? $this->getMinLength() : $this->getMaxLength();
    }
}
