<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stock;

class ApiStockController extends Controller
{
    public function show()
    {
        return Stock::paginate();
    }
}
