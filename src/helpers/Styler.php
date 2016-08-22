<?php

namespace eznio\tabler\helpers;


/**
 * Console style-applying helper
 * @package eznio\tabler\helpers
 */
class Styler
{
    const ESCAPE_TEMPLATE = "\033[%sm";
    const STYLE_RESET_SEQUENCE = '0';

    /**
     * Returns escape string to prepend to styled text for any amount of styles
     * If several styles of one type (bg-/fg-color) are presented - last one is used
     * @param $style
     * @return string
     */
    public static function get($style)
    {
        if (is_array($style)) {
            return self::getCombinedStyle($style);
        }
        return self::getSingleStyle($style);
    }

    /**
     * Returns escape string to prepend to styling text for single style
     * @param $style
     * @return string
     */
    public static function getSingleStyle($style)
    {
        return sprintf(
            self::ESCAPE_TEMPLATE,
            $style
        );
    }

    /**
     * Returns escape string to prepend to styling text for multiple styles
     * @param $style
     * @return string
     */
    public static function getCombinedStyle($style)
    {
        return sprintf(
            self::ESCAPE_TEMPLATE,
            implode(';', $style)
        );
    }

    /**
     * Returns escape string to reset custom style to default one. Should be appended to styled text
     * @return string
     */
    public static function getReset()
    {
        return self::getSingleStyle(self::STYLE_RESET_SEQUENCE);
    }
}
