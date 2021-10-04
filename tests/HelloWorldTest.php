<?php

namespace Tests;

use App\HelloWorld;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use SebastianBergmann\RecursionContext\InvalidArgumentException;

class HelloWorldTest extends TestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     * @covers \App\HelloWorld
     */
    public function testHello(): void
    {
        $defaultGreeter = new HelloWorld();

        $this->assertEquals('Hello, World', $defaultGreeter->hello());

        $this->assertEquals('Hello, Chris', $defaultGreeter->hello('Chris'));
        $this->assertEquals('Hello, ', $defaultGreeter->hello(''));
    }
}
