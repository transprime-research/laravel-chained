<?php

namespace Transprime\Chained\Tests;

use PHPUnit\Framework\TestCase;
use Transprime\Chained\{Chained, Exceptions\ChainedException};

class ChainedTest extends TestCase
{
    public function testChainedIsCreated()
    {
        $this->assertIsObject(new Chained([]));
    }

    public function testChainedHappyPath()
    {
        $chained = new Chained('a,b,c,d');

        $this->assertEquals(
            ['a', 'b', 'c', 'd'],
            $chained->on(Stringer::class)
                ->to('wrap')
                ->to('combine')
                ->to('split')
                ->up()
        );
    }

    public function testChainedWithHelperFunction()
    {
        $this->assertEquals(
            ['a', 'b', 'c', 'd'],
            chained('a,b,c,d')
                ->on(Stringer::class)
                ->to('wrap')
                ->to('combine')
                ->to('split')
                ->up()
        );
    }

    public function testProxiedCalls()
    {
        $this->assertEquals(
            ['a', 'b', 'c', 'd'],
            chained('a,b,c,d')
                ->on(Stringer::class)
                ->wrap()
                ->combine()
                ->split()
                ->up()
        );
    }

    public function testExtraParametersOnMethods()
    {
        $this->assertEquals(
            'a|b|c|d',
            chained('a,b,c,d')
                ->on(Stringer::class)
                ->tap(function ($res) {
                    $this->assertEquals('a,b,c,d', $res);
                })
                ->to('split')
                ->tap(function ($res) {
                    $this->assertEquals(['a','b','c','d'], $res);
                })
                ->to('combine', '|')
                ->up()
        );

        $this->assertEquals(
            'a|b|c|d',
            chained('a,b,c,d')
                ->on(Stringer::class)
                ->split()
                ->combine('|')
                ->up()
        );
    }

    public function testChainedCanBeInvoked()
    {
        $this->assertEquals(
            ['a', 'b', 'c', 'd'],
            chained('a,b,c,d')
                ->on(Stringer::class)
                ->to('wrap')
                ->to('combine')
                ->to('split')()
        );
    }
}

class Stringer
{
    public static function split(string $string, string $using = ',')
    {
        return explode($using, $string);
    }

    public static function combine(array $array, $glue = '')
    {
        return implode($glue, $array);
    }

    public function wrap($value)
    {
        return is_array($value) ? $value : [$value];
    }
}