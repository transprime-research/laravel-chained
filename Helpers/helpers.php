<?php

use Transprime\Chained\Chained;

if (! function_exists('chained')) {
    /**
     * New up a fresh Chained
     *
     * @param callable|Closure|null $class
     * @param mixed ...$arguments
     * @return Chained
     * @throws Exception
     */
    function chained($class = null, ...$arguments): Chained
    {
        return new Chained($class, ...$arguments);
    }
}