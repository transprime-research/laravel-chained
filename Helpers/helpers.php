<?php

use Transprime\Chained\Chained;

if (! function_exists('chained')) {
    /**
     * New up a fresh Chained
     *
     * @param $data
     * @return Chained
     */
    function chained($data) {
        return new Chained($data);
    }
}