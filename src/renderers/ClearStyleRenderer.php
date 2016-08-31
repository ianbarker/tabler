<?php

namespace eznio\tabler\renderers;

/**
 * Renders borderless table
 * @package eznio\tabler\renderers
 */
class ClearStyleRenderer extends AsciiTableRenderer
{
    /**
     * @return mixed
     */
    public function getTopLeftSymbol()
    {
        return '';
    }

    /**
     * @return mixed
     */
    public function getTopCrossingSymbol()
    {
        return '';
    }

    /**
     * @return mixed
     */
    public function getTopRightSymbol()
    {
        return '';
    }

    /**
     * @return mixed
     */
    public function getMiddleLeftSymbol()
    {
        return ' ';
    }

    /**
     * @return mixed
     */
    public function getMiddleCrossingSymbol()
    {
        return ' ';
    }

    /**
     * @return mixed
     */
    public function getMiddleRightSymbol()
    {
        return ' ';
    }

    /**
     * @return mixed
     */
    public function getBottomLeftSymbol()
    {
        return '';
    }

    /**
     * @return mixed
     */
    public function getBottomCrossingSymbol()
    {
        return '';
    }

    /**
     * @return mixed
     */
    public function getBottomRightSymbol()
    {
        return '';
    }

    /**
     * @return mixed
     */
    public function getHorizontalSymbol()
    {
        return '';
    }

    /**
     * @return mixed
     */
    public function getVerticalSymbol()
    {
        return '';
    }

}
