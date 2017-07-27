<?php

namespace App\Contracts;

class Test1 implements TestContract
{
    public function __construct()
    {
    }

    public function test($name = 'Test1')
    {
        echo $name;
    }
}
