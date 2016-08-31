<?php

namespace eznio\tabler\elements;


use eznio\tabler\references\Defaults;
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

    /** @var int */
    private $leftPadding = Defaults::PADDING_LEFT;

    /** @var int */
    private $rightPadding = Defaults::PADDING_RIGHT;

    /** @var bool */
    private $isFirst = false;

    /** @var bool */
    private $isLast = false;

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
     * Returns calculated field length
     * @return int
     */
    public function getLength()
    {
        return $this->getMaxLength() < $this->getMinLength() ? $this->getMinLength() : $this->getMaxLength();
    }

    /**
     * @return int
     */
    public function getLeftPadding()
    {
        return $this->leftPadding;
    }

    /**
     * @param int $leftPadding
     * @return $this
     */
    public function setLeftPadding($leftPadding)
    {
        $this->leftPadding = (int) $leftPadding > 0 ? (int) $leftPadding : 0;
        return $this;
    }

    /**
     * @return int
     */
    public function getRightPadding()
    {
        return $this->rightPadding;
    }

    /**
     * @param int $rightPadding
     * @return $this
     */
    public function setRightPadding($rightPadding)
    {
        $this->rightPadding = (int) $rightPadding > 0 ? (int) $rightPadding : 0;
        return $this;
    }

    /**
     * @return bool
     */
    public function getIsFirst()
    {
        return $this->isFirst;
    }

    /**
     * @param bool $isFirst
     * @return $this
     */
    public function setIsFirst($isFirst)
    {
        $this->isFirst = $isFirst;
        return $this;
    }

    /**
     * @return bool
     */
    public function getIsLast()
    {
        return $this->isLast;
    }

    /**
     * @param bool $isLast
     * @return $this
     */
    public function setIsLast($isLast)
    {
        $this->isLast = $isLast;
        return $this;
    }
}
