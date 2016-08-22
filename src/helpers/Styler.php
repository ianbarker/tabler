<?php

namespace eznio\tabler\helpers;


class Styler
{
    const ESCAPE_TEMPLATE = "\033[%sm";

    public static function get($style)
    {
        if (is_array($style)) {
            return self::getCombinedStyle($style);
        }
        return self::getSingleStyle($style);
    }

    public static function getSingleStyle($style)
    {
        return sprintf(
            self::ESCAPE_TEMPLATE,
            $style
        );
    }

    public static function getCombinedStyle($style)
    {
        return sprintf(
            self::ESCAPE_TEMPLATE,
            implode(';', $style)
        );
    }

    public static function getReset()
    {
        return self::getSingleStyle('0');
    }
}
