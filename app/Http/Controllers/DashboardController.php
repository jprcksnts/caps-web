<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $table_headers = ['code', 'product', 'quantity', 're-order point'];
        return view('dashboard', compact(['table_headers']));
    }
}
