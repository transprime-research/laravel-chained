<?php

namespace Transprime\Chained;

trait ChainedImpl
{
    public function __call($name, $arguments)
    {
        return $this->to($name, ...$arguments);
    }
}