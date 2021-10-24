<?php

namespace Transprime\Chained\Tests;

use PHPUnit\Framework\TestCase;
use Transprime\Chained\{Chained, Exceptions\ChainedException};

class ChainedTest extends TestCase
{
    public function testChainedIsCreated()
    {
        $this->assertIsObject(new Chained(Arrayer::class, []));
    }

    public function testChainedHappyPath()
    {
        $chained = new Chained(Stringer::class);

        $this->assertEquals(
            ['a', 'b', 'c', 'd'],
            $chained->to('wrap', 'a,b,c,d')
                ->to('combine')
                ->to('split')
                ->up()
        );
    }

    public function testChainedWithHelperFunction()
    {
        $this->assertEquals(
            ['a', 'b', 'c', 'd'],
            chained(Stringer::class)
                ->to('wrap', 'a,b,c,d')
                ->to('combine')
                ->to('split')
                ->up()
        );
    }

    public function testChainedWithOnMethod()
    {
        $this->assertEquals(
            ['a', 'b', 'c', 'd'],
            Chained::on(Stringer::class)
                ->to('wrap', 'a,b,c,d')
                ->to('combine')
                ->to('split')
                ->up()
        );
    }

    public function testProxiedCalls()
    {
        $this->assertEquals(
            ['a', 'b', 'c', 'd'],
            chained(Stringer::class)
                ->wrap('a,b,c,d')->combine()->split()()
        );
    }

    public function testExtraParametersOnMethods()
    {
        $this->assertEquals(
            'a|b|c|d',
            chained(Stringer::class)
                ->to('split', 'a,b,c,d')
                ->tap(function ($res) {
                    $this->assertEquals(['a','b','c','d'], $res);
                })
                ->to('combine', '|')
                ->up()
        );

        $this->assertEquals(
            'a|b|c|d',
            chained(Stringer::class)
                ->split('a,b,c,d')
                ->combine('|')
                ->up()
        );
    }

    public function testChainedCanBeInvoked()
    {
        $this->assertEquals(
            ['a', 'b', 'c', 'd'],
            chained(Stringer::class)
                ->to('wrap', 'a,b,c,d')
                ->to('combine')
                ->to('split')()
        );
    }

    public function testChainLikePiper()
    {
        $this->assertEquals(
            'bcd',
            chained()
                ->to('array_slice', ['a', 'b', 'c', 'd'], 1)
                ->to('implode')()
        );
    }

    public function testChainWithArguments()
    {
        $this->assertEquals(
            [0, 1],
            chained(Arrayer::class, ['a', 'b'])
                ->to('keys')()
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

class Arrayer
{
    /**
     * @var array
     */
    private $items;

    public function __construct($items = [])
    {
        $this->items = $items;
    }

    /**
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

    public function keys()
    {
        return array_keys($this->items);
    }
}