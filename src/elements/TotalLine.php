<?php

namespace eznio\tabler\elements;


use eznio\ar\Ar;
use eznio\styler\traits\StyleAware;

/**
 * "Total" line-representing rendering element
 * @package eznio\tabler\elements
 */
class TotalLine extends Element
{
    use StyleAware;

    /** @var array */
    protected $totals;

    /**
     * @param array $totals
     */
    public function setTotals(array $totals)
    {
        $this->totals= $totals;
    }

    /**
     * @return array
     */
    public function getTotals()
    {
        return $this->totals;
    }

    /**
     * @param $columnId
     * @param $value
     */
    public function setTotal($columnId, $value)
    {
        $this->totals[$columnId] = $value;
    }

    /**
     * @param $columnId
     * @return mixed
     */
    public function getTotal($columnId)
    {
        return Ar::get($this->totals, $columnId);
    }
}
