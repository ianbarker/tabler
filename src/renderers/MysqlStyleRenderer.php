<?php

namespace eznio\tabler\renderers;

/**
 * Mysql-style table renderer
 *
 * Example:
 * <pre>
 * +-----------+-----------+
 * | Column 1  | Column 2  |
 * +-----------+-----------+
 * | Value 1-1 | Value 2-1 |
 * | Value 1-2 | Value 2-2 |
 * | Value 1-3 | Value 2-3 |
 * +-----------+-----------+
 * </pre>
 *
 * @package eznio\tabler\renderers
 */
class MysqlStyleRenderer extends AsciiTableRenderer
{
    /**
     * @return mixed
     */
    public function getTopLeftSymbol()
    {
        return '+';
    }

    /**
     * @return mixed
     */
    public function getTopCrossingSymbol()
    {
        return '+';
    }

    /**
     * @return mixed
     */
    public function getTopRightSymbol()
    {
        return '+';
    }

    /**
     * @return mixed
     */
    public function getMiddleLeftSymbol()
    {
        return '+';
    }

    /**
     * @return mixed
     */
    public function getMiddleCrossingSymbol()
    {
        return '+';
    }

    /**
     * @return mixed
     */
    public function getMiddleRightSymbol()
    {
        return '+';
    }

    /**
     * @return mixed
     */
    public function getBottomLeftSymbol()
    {
        return '+';
    }

    /**
     * @return mixed
     */
    public function getBottomCrossingSymbol()
    {
        return '+';
    }

    /**
     * @return mixed
     */
    public function getBottomRightSymbol()
    {
        return '+';
    }

    /**
     * @return mixed
     */
    public function getHorizontalSymbol()
    {
        return '-';
    }

    /**
     * @return mixed
     */
    public function getVerticalSymbol()
    {
        return '|';
    }

}
