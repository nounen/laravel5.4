<?php

namespace App\Repositories;

// 接口的好处, 所有实现该接口的类都可以很方便的切换, 灵活
use App\Contracts\Test1 AS TestContract;
// use App\Contracts\Test2 AS TestContract;

class TestContractRepository
{
    protected $testContract;

    function __construct(TestContract $testContract)
    {
        $this->testContract = $testContract;
    }

    public function test()
    {
        $this->testContract->test();
    }
}
