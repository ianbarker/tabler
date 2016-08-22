<?php

namespace eznio\tabler;


use eznio\tabler\elements\TableLayout;
use eznio\tabler\interfaces\Renderer;

/**
 * Overall package facade
 * @package eznio\tabler
 */
class Tabler
{
    private $headers = [];
    private $data = [];
    private $totals = [];
    private $renderer = null;
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
     * @return Tabler
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
            $tableLayout = $this->buildTableLayout();
        }
        if (! $this->renderer instanceof Renderer) {
            throw new \RuntimeException('Set renderer class before rendering table');
        }
        return $this->renderer->render($tableLayout);
    }
}
