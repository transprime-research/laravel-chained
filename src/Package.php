<?php

namespace Transprime\Chained;

use Transprime\Chained\Exceptions\ChainedException;

class Chained
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }
}