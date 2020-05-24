<?php

namespace Transprime\Chained;

use Closure;
use Transprime\Chained\Exceptions\ChainedException;

class Chained
{
    use ChainedImpl;

    private $on;
    private $chain = [];
    private $arguments = [];
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

        $this->arguments[] = $extraParameters;

        return $this;
    }

    public function up()
    {
        return array_reduce($this->chain, function ($result, $function) {
            if ($function === 'tap') {
                array_shift($this->arguments)[0]($result);

                return $result;
            }

            return $this->on->$function($result, ...array_shift($this->arguments));
        }, $this->data);
    }

    private function buildOn($on, ...$arguments)
    {
        if (function_exists('app')) {

            $this->on = app($on, ...$arguments);

            return $this;
        }

        $this->on = new $on(...$arguments);

        return $this;
    }

    public function tap(Closure $tap)
    {
        return $this->to(__FUNCTION__, $tap);
    }
}