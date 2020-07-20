<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class InventoriesController extends Controller
{
    public function index()
    {
        $table_headers = ['product', 'branch', 'quantity', 'updated at'];
        return view('inventories.index', compact('table_headers'));
    }

    public function retrieveList()
    {
        $inventories = DB::table('inventories')
            ->select('inventories.quantity',
                'inventories.updated_at',
                'products.name as product_name',
                'branches.name as branch_name')
            ->leftJoin('products', 'inventories.product_id', '=', 'products.id')
            ->leftJoin('branches', 'inventories.branch_id', '=', 'branches.id');

        return DataTables::query($inventories)
            ->rawColumns(['action_column'])
            ->toJson();
    }
}
