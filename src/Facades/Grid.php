<?php
namespace Willypuzzle\Kendo\Facades;

use Illuminate\Support\Facades\Facade;

class Grid extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'willypuzzle.kendo.grid'; }
}