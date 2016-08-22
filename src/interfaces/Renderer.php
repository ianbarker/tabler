<?php

namespace eznio\tabler\interfaces;


use eznio\tabler\elements\TableLayout;

/**
 * Table rendering class interface
 * This interface should be implemented to register class as renderer in Tabler:
 * <pre>
 *   class MyRenderer implements Renderer { . . . }
 *   . . .
 *   $tabler = (new Tabler)->setRenderer(new MyRenderer());
 * </pre>
 * @package eznio\tabler\interfaces
 */
interface Renderer
{
    /**
     * Table rendering entry point
     * @param TableLayout $tableLayout table layout description
     * @return string rendered table output
     */
    public function render(TableLayout $tableLayout);
}
