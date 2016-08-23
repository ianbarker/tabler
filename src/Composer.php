<?php

namespace eznio\tabler;


use eznio\ar\Ar;

/**
 * Composes table from headers and data array, verifies its structure and "normalizes" it by
 * setting unset column elements for each row
 * @package eznio\tabler
 */
class Composer
{
    /** @var array list of headers before processing */
    protected $rawHeaders;

    /** @var array list of data before processing/normalization */
    protected $rawData;

    /** @var bool if non-existent header names should be taken from header array key names */
    protected $shouldGuessHeaders;

    /** @var array resulting headers after processing */
    protected $headers = [];

    /** @var array resulting data after processing/normalization */
    protected $data = [];

    /** @var array list of all column names found in headers/data */
    protected $columnNames = [];

    /** @var array list of all columns' maximum lengths */
    protected $columnMaxLengths = [];

    /**
     * Composer constructor.
     * @param array $headers array of column headers: 'columnId' => 'Column Title'
     * @param array $data 2D row-starting list of data
     * @param bool $shouldGuessHeaders if non-existent header names should be taken from header array key names
     */
    public function __construct(array $headers, array $data, $shouldGuessHeaders = false)
    {
        $this->rawData = $data;
        $this->rawHeaders = $headers;
        $this->shouldGuessHeaders = $shouldGuessHeaders;
    }

    /**
     * Processes all data preparation and normalization.
     * Generates $headers and $data internal fields
     */
    public function composeTable()
    {
        $this->gatherColumnNames();
        $this->gatherColumnMaxLengths();
        $this->processHeaders();
        $this->processData();
    }

    /**
     * Gathers full possible list of column IDs and names from both headers and data
     */
    private function gatherColumnNames()
    {
        $this->columnNames = Ar::reduce($this->rawData, function($row, $columns) {
            return array_unique(array_merge($columns, array_keys($row)));
        }, array_keys($this->rawHeaders));
    }

    /**
     * Gathers columns' max lengths
     */
    private function gatherColumnMaxLengths()
    {
        $this->gatherColumnMaxLengthsFromData();
        $this->gatherColumnMaxLengthsFromGuessedHeaderNames();
        $this->gatherColumnMaxLengthsFromHeaders();
    }

    /**
     * "Normalizes" headers - adds missing ones and tries to set labels if asked to
     */
    private function processHeaders()
    {
        $this->headers = Ar::map($this->columnNames, function($column)  {
            $headerName = Ar::get($this->rawHeaders, $column);
            if (null === $headerName) {
                $headerName = $this->shouldGuessHeaders ? $column : '';
            }
            return [$column => $headerName];
        });
    }

    /**
     * "Normalizes" data - adds missing columns if needed
     */
    private function processData()
    {
        foreach ($this->rawData as $rowId => $row) {
            $formattedRow = [];
            foreach ($this->columnMaxLengths as $columnId => $column) {
                $formattedRow[$columnId] = Ar::get($row, $columnId);
            }
            $this->data[$rowId] = $formattedRow;
        }
    }

    /**
     * Get list of processed headers
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Get processed data grid
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Get list of all column IDs and labels found
     * @return array
     */
    public function getColumnNames()
    {
        return $this->columnNames;
    }

    /**
     * Get list of all columns' max lengths
     * @return array
     */
    public function getColumnMaxLengths()
    {
        return $this->columnMaxLengths;
    }

    /**
     * Gathers column names' lengths from data
     */
    private function gatherColumnMaxLengthsFromData()
    {
        foreach ($this->rawData as $row) {
            if (!is_array($row)) {
                continue;
            }

            foreach ($this->columnNames as $columnId) {
                $this->columnMaxLengths[$columnId] = max(
                    Ar::get($this->columnMaxLengths, $columnId),
                    strlen(Ar::get($row, $columnId)),
                    strlen(Ar::get($this->rawHeaders, $columnId)),
                    0
                );
            }
        }
    }

    /**
     * Gathers column names' lengths from passed headers
     */
    private function gatherColumnMaxLengthsFromHeaders()
    {
        foreach ($this->rawHeaders as $columnId => $item) {
            if (strlen($item) > Ar::get($this->columnMaxLengths, $columnId)) {
                $this->columnMaxLengths[$columnId] = strlen($item);
            }
        }
    }

    /**
     * Gathers column names' lengths from auto-guessed headers (if auto-guessing is enabled)
     */
    private function gatherColumnMaxLengthsFromGuessedHeaderNames()
    {
        if (false === $this->shouldGuessHeaders) {
            return;
        }
        $headers = array_combine(array_values($this->columnNames), array_values($this->columnNames));
        foreach ($headers as $columnId => $item) {
            if (strlen($item) > Ar::get($this->columnMaxLengths, $columnId)) {
                $this->columnMaxLengths[$columnId] = strlen($item);
            }
        }

    }
}
