<?php

namespace eznio\tabler\traits;


use eznio\ar\Ar;
use eznio\tabler\references\BackgroundColors;
use eznio\tabler\references\ForegroundColors;

/**
 * Supports setting linux console styles for the elements
 * Style constants are defined in linux console and supported by Style helper
 * Reference constants can be found in \eznio\tabler\references namespace
 * @see http://misc.flogisoft.com/bash/tip_colors_and_formatting
 * @package eznio\tabler\traits
 */
trait StyleAware
{
    /** @var array */
    protected $styles = [];

    /**
     * Add single style line
     * @param $style
     * @return $this
     */
    public function addStyle($style)
    {
        $this->styles[$style] = $style;
        return $this;
    }

    /**
     * Remove single style line
     * @param $style
     */
    public function removeStyle($style)
    {
        unset($this->styles[$style]);
    }

    /**
     * Set all styles at once
     * @param $styles
     * @return $this
     */
    public function setStyles($styles)
    {
        $this->styles = array_merge($this->styles, $styles);
        return $this;
    }

    /**
     * Get all styles at once
     * @return array
     */
    public function getStyles()
    {
        return $this->styles;
    }

    /**
     * Set element foreground color
     * If any other fg color constant was added before - it will be removed
     * @param $color
     */
    public function setForegroundColor($color)
    {
        $this->setColor($color, ForegroundColors::ALL);
    }

    /**
     * Get element foreground color
     * @return int
     */
    public function getForegroundColor()
    {
        return $this->getColor(ForegroundColors::ALL);
    }

    /**
     * Set element background color
     * If any other bg color constant was added before - it will be removed
     * @param $color
     */
    public function setBackgroundColor($color)
    {
        $this->setColor($color, BackgroundColors::ALL);
    }

    /**
     * Get element background color
     * @return int
     */
    public function getBackgroundColor()
    {
        return $this->getColor(BackgroundColors::ALL);
    }

    /**
     * Returns first element of given reference
     * @param array $reference
     * @return mixed
     */
    private function getColor(array $reference)
    {
        return Ar::reduce($this->styles, function($item, $prevValue) use ($reference) {
            if (null !== $prevValue) {
                return $prevValue;
            }
            if (in_array($item, $reference)) {
                return $item;
            }
            return null;
        });
    }

    /**
     * Sets style and removes all other styles from given reference
     * @param $color
     * @param array $reference
     */
    private function setColor($color, array $reference)
    {
        $this->styles = Ar::reject($this->styles, function ($item) use ($reference) {
            return in_array($item, $reference);
        });
        $this->addStyle($color);
    }
}
