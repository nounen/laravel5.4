<?php

namespace App\Contracts;

class Test2 implements TestContract
{
    public function __construct()
    {
    }

    public function test($name = 'Test2')
    {
        echo $name;
    }
}
