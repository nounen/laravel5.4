<?php

namespace App\Http\Controllers;

use App\Repositories\TestContractRepository;

class TestContractController extends Controller
{
    protected $r;

    public function __construct(TestContractRepository $r)
    {
        $this->r = $r;
    }

    public function index()
    {
        $this->r->test();
    }
}
