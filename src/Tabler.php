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

    public function setHeaders(array $headers)
    {
        $this->headers = $headers;
        return $this;
    }

    public function setData(array $data)
    {
        $this->data = $data;
        return $this;
    }

    public function setTotals(array $totals)
    {
        $this->totals = $totals;
        return $this;
    }

    public function getTableLayout()
    {
        if (null === $this->tableLayout) {
            $this->buildTableLayout();
        }
        return $this->tableLayout;
    }

    public function buildTableLayout()
    {
        $composer = new Composer($this->headers, $this->data, $this->guessHeaderNames);
        $composer->composeTable();

        $builder = new LayoutBuilder();
        $this->tableLayout = $builder->buildTableLayout($composer);

        return $this->tableLayout;
    }

    public function setRenderer(Renderer $renderer)
    {
        $this->renderer = $renderer;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isGuessingHeaderNames()
    {
        return $this->guessHeaderNames;
    }

    /**
     * @param boolean $guessHeaderNames
     * @return Tabler
     */
    public function setGuessHeaderNames($guessHeaderNames)
    {
        $this->guessHeaderNames = $guessHeaderNames;
        return $this;
    }

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
