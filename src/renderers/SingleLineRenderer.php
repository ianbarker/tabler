<?php

namespace eznio\tabler\renderers;


/**
 * Single-line table borders
 *
 * Example:
 * <pre>
    ┌───────┬─────┬───────────┐
    │     a │  b  │ cccccccc  │
    ├───────┼─────┼───────────┤
    │     1 │     │           │
    │       │  2  │           │
    │       │     │ 3         │
    │     1 │     │           │
    │       │  2  │           │
    │       │     │ 3         │
    │     1 │     │           │
    │       │  2  │           │
    │       │     │ 3         │
    └───────┴─────┴───────────┘
 * </pre<
 * @package eznio\tabler\renderers
 */
class SingleLineRenderer extends AsciiTableRenderer
{
    /**
     * @return mixed
     */
    public function getTopLeftSymbol()
    {
        return '┌';
    }

    /**
     *
     */
    public function getTopCrossingSymbol()
    {
        return '┬';
    }

    /**
     * @return mixed
     */
    public function getTopRightSymbol()
    {
        return '┐';
    }

    /**
     * @return mixed
     */
    public function getMiddleLeftSymbol()
    {
        return '├';
    }

    /**
     *
     */
    public function getMiddleCrossingSymbol()
    {
        return '┼';
    }

    /**
     * @return mixed
     */
    public function getMiddleRightSymbol()
    {
        return '┤';
    }

    /**
     * @return mixed
     */
    public function getBottomLeftSymbol()
    {
        return '└';
    }

    /**
     * @return mixed
     */
    public function getBottomCrossingSymbol()
    {
        return '┴';
    }

    /**
     * @return mixed
     */
    public function getBottomRightSymbol()
    {
        return '┘';
    }

    /**
     * @return mixed
     */
    public function getHorizontalSymbol()
    {
        return '─';
    }

    /**
     * @return mixed
     */
    public function getVerticalSymbol()
    {
        return '│';
    }
}
