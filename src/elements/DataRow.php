<?php

namespace eznio\tabler\elements;


use eznio\ar\Ar;
use eznio\tabler\traits\StyleAware;

/**
 * Rendering element representing single data row
 * @package eznio\tabler\elements
 */
class DataRow extends Element
{
    use StyleAware;

    const ORDER_ANY = 1;
    const ORDER_ODD = 2;
    const ORDER_EVEN = 3;
    const ORDERS = [self::ORDER_ANY, self::ORDER_ODD, self::ORDER_EVEN];

    /**
     * @var array List of row's cells
     */
    protected $data = [];

    /**
     * @var int Row's position - odd, even, or "don't look at this field"
     */
    protected $order = self::ORDER_ANY;

    /**
     * Set row's fields
     * @param array $data
     * @return $this
     */
    public function setData(array $data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Add single field to row
     * @param DataCell $cell
     * @return $this
     */
    public function addCell(DataCell $cell) {
        $this->data[$cell->getId()] = $cell;
        return $this;
    }

    /**
     * Get cell by it's ID
     * @param $cellId
     * @return DataCell|null
     */
    public function getCell($cellId)
    {
        return Ar::get($this->data, $cellId);
    }

    /**
     * Get all cells
     * @return array
     */
    public function getCells()
    {
        return $this->data;
    }

    /**
     * Set row "order" - odd, even, or "don't look at this field"
     * @param $order
     * @return $this
     */
    public function setOrder($order)
    {
        if (in_array($order, self::ORDERS)) {
            $this->order = $order;
        }
        return $this;
    }

    /**
     * Get row order
     * @return int
     */
    public function getOrder()
    {
        return $this->order;
    }
}
