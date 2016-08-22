<?php

namespace eznio\tabler\elements;


use eznio\ar\Ar;
use eznio\tabler\traits\StyleAware;

class TotalLine extends Element
{
    use StyleAware;

    protected $totals;

    public function setTotals(array $totals)
    {
        $this->totals= $totals;
    }

    public function getTotals()
    {
        return $this->totals;
    }

    public function setTotal($columnId, $value)
    {
        $this->totals[$columnId] = $value;
    }

    public function getTotal($columnId)
    {
        return Ar::get($this->totals, $columnId);
    }
}
