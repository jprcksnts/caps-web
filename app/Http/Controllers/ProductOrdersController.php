<?php

namespace App\Http\Controllers;

use App\Models\Product\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ProductOrdersController extends Controller
{
    public function index()
    {
        $table_headers = ['id', 'product', 'quantity', 'expected arrival date', ''];
        return view('product_orders.index', compact('table_headers'));
    }

    public function create()
    {
        $products = Product::all();
        $form_action = [
            'page_title' => 'Create New Product Order',
            'route' => route('product_orders.store'),
        ];
        return view('product_orders.form', compact('form_action', 'products'));
    }

    public function retrieveList()
    {
        $product_orders = DB::table('product_orders')
            ->select('product_orders.id',
                'products.name as product_name',
                'product_orders.quantity',
                'product_orders.expected_arrival_date')
            ->leftJoin('products', 'product_orders.product_id', '=', 'products.id');

        return DataTables::query($product_orders)
            ->addColumn('action_column', function ($product_order) {
                $route = route('product_orders.show', ['product_order' => $product_order->id]);
                return '<a href="' . $route . '" class="table-action"><i class="fas fa-chevron-right"></i></a>';
            })
            ->rawColumns(['action_column'])
            ->toJson();
    }
}
