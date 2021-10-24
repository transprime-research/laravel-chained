<?php

namespace Transprime\Chained;

use Closure;
use Exception;
use phpDocumentor\Reflection\Types\This;
use Transprime\Chained\Exceptions\ChainedException;

class Chained
{
    use ChainedImpl;

    private $on;
    private $chain = [];
    private $arguments = [];

    public function __construct($class = null, ...$arguments)
    {
        if (null !== $class && !is_string($class) && !is_callable($class)) {
            throw new Exception('class must be callable');
        }

        $this->buildOn($class,...$arguments);
    }

    public function __invoke()
    {
        return $this->up();
    }

    public static function on($on, ...$arguments)
    {
        return new static($on, ...$arguments);
    }

    /**
     * @param callable|string $function
     * @param mixed ...$extraParameters
     * @return $this
     */
    public function to(string $function, ...$extraParameters)
    {
        $this->chain[] = $function;

        $this->arguments[] = $extraParameters;

        return $this;
    }

    public function up()
    {
        return array_reduce($this->chain, $this->resolveChains());
    }

    private function resolveChains(): Closure
    {
        return function ($result, $function) {
            if ($function === 'tap') {
                array_shift($this->arguments)[0]($result);

                return $result;
            }


            if ($this->on && $result) {
                return $this->on->$function($result, ...array_shift($this->arguments));
            } elseif ($this->on && !$result) {
                return $this->on->$function(...array_shift($this->arguments));
            }

            if ($result) {
                return $function($result, ...array_shift($this->arguments));
            }

            return $function(...array_shift($this->arguments));
        };
    }

    private function buildOn($on = null, ...$arguments)
    {
        if ($this->on) {
            throw new Exception('buildOn() is already called');
        }

        if (!$on) {
            return $this;
        }

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