<?php

namespace eznio\tabler\elements;


use eznio\ar\Ar;
use eznio\tabler\traits\StyleAware;

class DataRow extends Element
{
    use StyleAware;

    const ORDER_ANY = 0;
    const ORDER_ODD = 1;
    const ORDER_EVEN = 2;
    const ORDERS = [self::ORDER_ANY, self::ORDER_ODD, self::ORDER_EVEN];

    protected $data;
    protected $order = self::ORDER_ANY;

    public function setData(array $data)
    {
        $this->data = $data;
        return $this;
    }

    public function addCell(DataCell $cell) {
        $this->data[$cell->getId()] = $cell;
        return $this;
    }

    public function getCell($cellId)
    {
        return Ar::get($this->data, $cellId);
    }

    public function getCells()
    {
        return $this->data;
    }

    public function setOrder($order)
    {
        if (in_array($order, self::ORDERS)) {
            $this->order = $order;
        }
        return $this;
    }

    public function getOrder()
    {
        return $this->order;
    }
}
