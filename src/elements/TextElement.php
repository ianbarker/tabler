<?php

namespace eznio\tabler\elements;


use eznio\tabler\traits\TextAlignmentAware;

class TextElement extends Element
{
    use TextAlignmentAware;

    const TEXT_ALIGN_LEFT = STR_PAD_RIGHT;
    const TEXT_ALIGN_RIGHT = STR_PAD_LEFT;
    const TEXT_ALIGN_CENTER = STR_PAD_BOTH;
    const TEXT_ALIGN_INHERIT = null;
}
