<?php

namespace App;

class HelloWorld
{
    private string $greeting;

    public function __construct(string $greeting = 'Hello, ')
    {
        $this->greeting = $greeting;
    }

    public function hello(string $name = 'World'): string
    {
        return $this->greeting . $name;
    }
}