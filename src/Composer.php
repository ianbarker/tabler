<?php

namespace eznio\tabler;


use eznio\ar\Ar;

class Composer
{
    protected $rawHeaders;
    protected $rawData;
    protected $shouldGuessHeaders;

    protected $headers = [];
    protected $data = [];
    protected $columnNames = [];
    protected $columnMaxLengths = [];

    public function __construct(array $headers, array $data, $shouldGuessHeaders = false)
    {
        $this->rawData = $data;
        $this->rawHeaders = $headers;
        $this->shouldGuessHeaders = $shouldGuessHeaders;
    }

    public function composeTable()
    {
        $this->gatherColumnNames();
        $this->gatherColumnMaxLengths();
        $this->processHeaders();
        $this->processData();
    }

    private function gatherColumnNames()
    {
        $this->columnNames = Ar::reduce($this->rawData, function($row, $columns) {
            return array_unique(array_merge($columns, array_keys($row)));
        }, array_keys($this->rawHeaders));
    }

    private function gatherColumnMaxLengths()
    {
        $maxLengths = [];
        foreach ($this->rawData as $rowId => $row) {
            if (!is_array($row)) {
                continue;
            }

            foreach ($this->columnNames as $columnId) {
                $maxLengths[$columnId] = max(
                    Ar::get($maxLengths, $columnId),
                    strlen(Ar::get($row, $columnId)),
                    strlen(Ar::get($this->rawHeaders, $columnId))
                );
            }
        }

        if (0 === count($this->rawHeaders)) {
            return;
        }

        if (count($this->rawHeaders) !== count(array_keys(current($this->rawData)))) {
            return;
        }

        $headers = array_combine(array_keys(current($this->rawData)), $this->rawHeaders);
        foreach ($headers as $columnId => $item) {
            if (strlen($item) > Ar::get($maxLengths, $columnId)) {
                $maxLengths[$columnId] = strlen($item);
            }
        }

        $this->columnMaxLengths = $maxLengths;
    }

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
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param array $headers
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getColumnNames()
    {
        return $this->columnNames;
    }

    /**
     * @param array $columnNames
     */
    public function setColumnNames($columnNames)
    {
        $this->columnNames = $columnNames;
    }

    /**
     * @return array
     */
    public function getColumnMaxLengths()
    {
        return $this->columnMaxLengths;
    }

    /**
     * @param array $columnMaxLengths
     */
    public function setColumnMaxLengths($columnMaxLengths)
    {
        $this->columnMaxLengths = $columnMaxLengths;
    }


}
