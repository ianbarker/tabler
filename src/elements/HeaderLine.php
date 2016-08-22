<?php

namespace eznio\tabler\elements;


use eznio\ar\Ar;
use eznio\tabler\traits\StyleAware;

class HeaderLine extends Element
{
    use StyleAware;

    protected $headers = [];

    public function setHeaders(array $headers)
    {
        $this->headers = $headers;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function addHeader($columnId, $value)
    {
        $this->headers[$columnId] = $value;
    }

    public function getHeader($columnId)
    {
        return Ar::get($this->headers, $columnId);
    }
}
