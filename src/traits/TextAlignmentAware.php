<?php

namespace eznio\tabler\traits;


trait TextAlignmentAware
{
    /** @var int */
    private $textAlignment = null;


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
}
