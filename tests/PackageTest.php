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
}