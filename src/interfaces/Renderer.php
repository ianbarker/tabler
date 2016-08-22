<?php

namespace eznio\tabler\interfaces;


use eznio\tabler\elements\TableLayout;

interface Renderer
{
    public function render(TableLayout $tableLayout);
}
