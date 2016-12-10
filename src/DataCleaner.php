<?php

namespace eznio\tabler;


use eznio\ar\Ar;

/**
 * Cleas up input data from non-scalar values
 * @package eznio\tabler
 */
class DataCleaner
{
    public function cleanupHeaders($headers)
    {
        return Ar::map($headers, function($item, $key) {
            return [$key => is_scalar($item) ? $item : null];
        });
    }

    public function cleanupData($data)
    {
        return Ar::map($data, function($row, $key) {
            if (is_array($row)) {
                return [
                    $key => Ar::map($row, function ($cell, $cellId) {
                        return [$cellId => is_scalar($cell) ? $cell : null];
                    })
                ];
            } else {
                return null;
            }
        });
    }

}
