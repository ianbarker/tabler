<?php

namespace eznio\tabler\traits;


use eznio\ar\Ar;
use eznio\tabler\references\BackgroundColors;
use eznio\tabler\references\ForegroundColors;

trait StyleAware
{
    protected $styles;

    public function addStyle($style)
    {
        $this->styles[$style] = $style;
    }

    public function removeStyle($style)
    {
        unset($this->styles[$style]);
    }

    public function setStyles($styles)
    {
        $this->styles = array_combine($styles, $styles);
    }

    public function getStyles()
    {
        return $this->styles;
    }

    public function setForegroundColor($color)
    {
        $this->setColor($color, ForegroundColors::ALL);
    }

    public function getForegroundColor()
    {
        return $this->getColor(ForegroundColors::ALL);
    }

    public function setBackgroundColor($color)
    {
        $this->setColor($color, BackgroundColors::ALL);
    }

    public function getBackgroundColor()
    {
        return $this->getColor(BackgroundColors::ALL);
    }

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

    private function setColor($color, array $reference)
    {
        $this->styles = Ar::reject($this->styles, function ($item) use ($reference) {
            return in_array($item, $reference);
        });
        $this->addStyle($color);
    }
}
