<?php

namespace Transprime\Chained;

use Transprime\Chained\Exceptions\ChainedException;

class Chained
{
    private $on;
    private $chain = [];
    private $extraParameters = [];
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function on($on)
    {
       return $this->buildOn($on);
    }

    public function to(string $function, ...$extraParameters)
    {
        $this->chain[] = $function;

        empty($extraParameters) ?: $this->extraParameters[count($this->chain) - 1] = $extraParameters;

        return $this;
    }

    public function up()
    {
        return array_reduce($this->chain, function ($result, $function) {
            $result = $this->on->$function($result);

            return $result;
        }, $this->data);
    }

    private function buildOn($on, ...$arguments)
    {
        if (function_exists('app')) {

            $this->on = app($on, $arguments);

            return $this;
        }

        $this->on = new $on(...$arguments);

        return $this;
    }
}