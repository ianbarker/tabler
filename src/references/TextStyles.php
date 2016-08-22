<?php

namespace eznio\tabler\references;


class TextStyles
{
    const RESET = 0;
    const BOLD = 1;
    const DIM = 2;
    const UNDERLINED = 4;
    const INVERTED = 7;

    const ALL = [
        self::RESET,
        self::BOLD,
        self::DIM,
        self::UNDERLINED,
        self::INVERTED
    ];
}
