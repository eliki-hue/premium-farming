<?php

namespace App\Http\Controllers;

use App\Services\DjangoInventoryService;

class BranchController extends Controller
{
    public function index(DjangoInventoryService $service)
    {
        $branches = $service->branches();
        return view('branches.index', compact('branches'));
    }
}
