<?php

namespace eznio\tabler;


use eznio\tabler\elements\DataRow;
use eznio\tabler\elements\TableLayout;
use eznio\tabler\interfaces\Renderer;
use eznio\ar\Ar;

/**
 * Overall package facade
 * @package eznio\tabler
 */
class Tabler
{
    /** @var array table headers */
    private $headers = [];

    /** @var array table data */
    private $data = [];

    /** @var array "Total" line */
    private $totals = [];

    /** @var Renderer|null rendering engine*/
    private $renderer = null;

    /** @var bool whether to get missing column names from column IDs */
    private $guessHeaderNames = false;

    /** @var TableLayout */
    private $tableLayout = null;

    /**
     * Set array of headers
     * Each array element should have the following format: 'columnId' => 'Column Label'
     * @param array $headers
     * @return $this
     */
    public function setHeaders(array $headers)
    {
        $this->headers = $headers;
        return $this;
    }

    /**
     * Set 2D array of data with the following format:
     * <pre>
     * [
     *     'rowId1' => [
     *         'columnId1' => 'Column 1 value',
     *         'columnId2' => 'Column 2 value',
     *     ]
     * ]
     * </pre>
     * @param array $data
     * @return $this
     */
    public function setData(array $data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Sets the "Total" line
     * @param array $totals
     * @return $this
     */
    public function setTotals(array $totals)
    {
        $this->totals = $totals;
        return $this;
    }

    /**
     * Returns TableLayout component with all data required to render table
     * This should be passed to Renderer::render() method
     * @return TableLayout
     */
    public function getTableLayout()
    {
        if (null === $this->tableLayout) {
            $this->buildTableLayout();
        }
        return $this->tableLayout;
    }

    /**
     * Build TableLayout structure with all data required to render table
     * @return TableLayout
     */
    public function buildTableLayout()
    {
        $composer = new Composer($this->headers, $this->data, $this->guessHeaderNames);
        $composer->composeTable();

        $builder = new LayoutBuilder();
        $this->tableLayout = $builder->buildTableLayout($composer);

        return $this->tableLayout;
    }

    /**
     * Sets rendering engine to render the table
     * @param Renderer $renderer
     * @return $this
     * @see \eznio\tabler\interfaces\Renderer
     */
    public function setRenderer(Renderer $renderer)
    {
        $this->renderer = $renderer;
        return $this;
    }

    /**
     * Are non-existent column names should be guesses from column IDs?
     * @return boolean
     */
    public function isGuessingHeaderNames()
    {
        return $this->guessHeaderNames;
    }

    /**
     * Sets if non-existent column names should be guesses from column IDs
     * @param boolean $guessHeaderNames
     * @return $this
     */
    public function setGuessHeaderNames($guessHeaderNames)
    {
        $this->guessHeaderNames = $guessHeaderNames;
        return $this;
    }

    /**
     * Renders tables using pre-set renderer and given od internally stored TableLayout structure
     * @param TableLayout|null $tableLayout structure to render
     * @return string
     */
    public function render(TableLayout $tableLayout = null)
    {
        if (null === $tableLayout) {
            $tableLayout = $this->tableLayout;
        }
        if (null === $tableLayout) {
            $tableLayout = $this->buildTableLayout();
        }
        if (! $this->renderer instanceof Renderer) {
            throw new \RuntimeException('Set renderer class before rendering table');
        }
        return $this->renderer->render($tableLayout);
    }

    // Some styling shortcuts

    /**
     * Set border background color
     * @param $color
     * @return $this
     */
    public function setBorderBackgroundColor($color)
    {
        if (null === $this->tableLayout) {
            $this->buildTableLayout();
        }
        $this->tableLayout->setBackgroundColor($color);
        return $this;
    }

    /**
     * Get border background color
     * @return int
     */
    public function getBorderBackgroundColor()
    {
        if (null === $this->tableLayout) {
            $this->buildTableLayout();
        }
        return $this->tableLayout->getBackgroundColor();
    }

    /**
     * Set border foreground color
     * @param $color
     * @return $this
     */
    public function setBorderForegroundColor($color)
    {
        if (null === $this->tableLayout) {
            $this->buildTableLayout();
        }
        $this->tableLayout->setForegroundColor($color);
        return $this;
    }

    /**
     * Get border background color
     * @return int
     */
    public function getBorderForegroundColor()
    {
        if (null === $this->tableLayout) {
            $this->buildTableLayout();
        }
        return $this->tableLayout->getForegroundColor();
    }

    /**
     * Set whole heading line styles
     * @param array $styles
     * @return $this
     */
    public function setHeadingLineStyles(array $styles)
    {
        if (null === $this->tableLayout) {
            $this->buildTableLayout();
        }
        $this->tableLayout->getHeaderLine()->setStyles($styles);
        return $this;
    }

    /**
     * Get whole heading line styles
     * @return array
     */
    public function getHeadingLineStyles()
    {
        if (null === $this->tableLayout) {
            $this->buildTableLayout();
        }
        return $this->tableLayout->getHeaderLine()->getStyles();
    }

    /**
     * Set heading cell styles
     * @param $columnId
     * @param array $styles
     * @return $this
     */
    public function setHeadingCellStyles($columnId, array $styles)
    {
        if (null === $this->tableLayout) {
            $this->buildTableLayout();
        }
        $headerCell = $this->tableLayout->getHeaderLine()->getHeaderCell($columnId);
        if (null !== $headerCell) {
            $headerCell->setStyles($styles);
        }
        return $this;
    }

    /**
     * Get heading cell styles
     * @param $columnId
     * @return array
     */
    public function getHeadingCellStyles($columnId)
    {
        if (null === $this->tableLayout) {
            $this->buildTableLayout();
        }
        $headerCell = $this->tableLayout->getHeaderLine()->getHeaderCell($columnId);
        return null === $headerCell ? [] : $headerCell->getStyles();
    }

    /**
     * Set whole column styles
     * @param $columnId
     * @param array $styles
     * @return $this
     */
    public function setColumnStyles($columnId, array $styles)
    {
        if (null === $this->tableLayout) {
            $this->buildTableLayout();
        }
        Ar::each ($this->getTableLayout()->getDataGrid()->getRows(), function (DataRow $row) use ($columnId, $styles) {
            $cell = $row->getCell($columnId);
            if (null !== $cell) {
               $cell->setStyles($styles);
            }
        });
        return $this;
    }

    /**
     * Set single column text alignment
     * @param $columnId
     * @param $alignment
     * @return $this
     */
    public function setColumnTextAlignment($columnId, $alignment)
    {
        if (null === $this->tableLayout) {
            $this->buildTableLayout();
        }
        $headerCell = $this->tableLayout->getHeaderLine()->getHeaderCell($columnId);
        if (null !== $headerCell) {
            $headerCell->setTextAlignment($alignment);
        }
        return $this;
    }

    /**
     * Set single column minimum length (width)
     * @param $columnId
     * @param $minLength
     * @return $this
     */
    public function setColumnMinLength($columnId, $minLength)
    {
        if (null === $this->tableLayout) {
            $this->buildTableLayout();
        }

        $headerCell = $this->tableLayout->getHeaderLine()->getHeaderCell($columnId);
        if (null !== $headerCell) {
            $headerCell->setMinLength($minLength);
        }

        $rows = $this->tableLayout->getDataGrid()->getRows();
        Ar::each($rows, function(DataRow $row) use ($columnId, $minLength) {
            $cell = $row->getCell($columnId);
            if (null !== $cell) {
                $cell->setMinLength($minLength);
            }
        });

        return $this;
    }

    /**
     * Get single row styles
     * @param $rowId
     * @param array $styles
     * @return $this
     */
    public function setRowStyles($rowId, array $styles)
    {
        if (null === $this->tableLayout) {
            $this->buildTableLayout();
        }
        $row = $this->tableLayout->getDataGrid()->getRow($rowId);
        if (null !== $row) {
            $row->setStyles($styles);
        }
        return $this;
    }

    /**
     * Get single row styles
     * @param $rowId
     * @return array
     */
    public function getRowStyles($rowId)
    {
        if (null === $this->tableLayout) {
            $this->buildTableLayout();
        }
        $row = $this->tableLayout->getDataGrid()->getRow($rowId);
        return null === $row ? $row : $row->getStyles();
    }

    /**
     * Set styles for odd rows
     * @param array $styles
     * @return $this
     */
    public function setOddRowsStyles(array $styles)
    {
        if (null === $this->tableLayout) {
            $this->buildTableLayout();
        }
        $rows = $this->tableLayout->getDataGrid()->getRows();
        $oddRows = Ar::filter($rows, function(DataRow $row) {
            return DataRow::ORDER_ODD === $row->getOrder();
        });

        Ar::each($oddRows, function(DataRow $row) use ($styles) {
            $row->setStyles($styles);
        });
        return $this;
    }

    /**
     * Set styles for even rows
     * @param array $styles
     * @return $this
     */
    public function setEvenRowsStyles(array $styles)
    {
        if (null === $this->tableLayout) {
            $this->buildTableLayout();
        }
        $rows = $this->tableLayout->getDataGrid()->getRows();
        $oddRows = Ar::filter($rows, function(DataRow $row) {
            return DataRow::ORDER_EVEN === $row->getOrder();
        });

        Ar::each($oddRows, function(DataRow $row) use ($styles) {
            $row->setStyles($styles);
        });
        return $this;
    }

    /**
     * Set single cell styles
     * @param $columnId
     * @param $rowId
     * @param array $styles
     * @return $this
     */
    public function setCellStyles($columnId, $rowId, array $styles)
    {
        if (null === $this->tableLayout) {
            $this->buildTableLayout();
        }
        $row = $this->tableLayout->getDataGrid()->getRow($rowId);
        if (null === $row) {
            return $this;
        }
        $cell = $row->getCell($columnId);
        if (null === $cell) {
            return $this;
        }
        $cell->setStyles($styles);
        return $this;
    }

    /**
     * Get single cell styles
     * @param $columnId
     * @param $rowId
     * @return array
     */
    public function getCellStyles($columnId, $rowId)
    {
        if (null === $this->tableLayout) {
            $this->buildTableLayout();
        }
        $row = $this->tableLayout->getDataGrid()->getRow($rowId);
        if (null === $row) {
            return [];
        }
        $cell = $row->getCell($columnId);
        return null === $cell ? $cell : $cell->getStyles();
    }

    /**
     * Set single cell text alignment
     * @param $columnId
     * @param $rowId
     * @param $alignment
     * @return $this
     */
    public function setCellTextAlignment($columnId, $rowId, $alignment)
    {
        if (null === $this->tableLayout) {
            $this->buildTableLayout();
        }
        $row = $this->tableLayout->getDataGrid()->getRow($rowId);
        if (null === $row) {
            return $this;
        }
        $cell = $row->getCell($columnId);
        if (null === $cell) {
            return $this;
        }
        $cell->setTextAlignment($alignment);
        return $this;
    }

    /**
     * Get single cell text alignment
     * @param $columnId
     * @param $rowId
     * @return int
     */
    public function getCellTextAlignment($columnId, $rowId)
    {
        if (null === $this->tableLayout) {
            $this->buildTableLayout();
        }
        $row = $this->tableLayout->getDataGrid()->getRow($rowId);
        if (null === $row) {
            return null;
        }
        $cell = $row->getCell($columnId);
        return null === $cell ? $cell : $cell->getTextAlignment();
    }
}
