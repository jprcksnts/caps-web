<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Core\Product\ProductOrderController;
use App\Models\Branch\Branch;
use App\Models\Product\Product;
use App\Models\Product\ProductOrder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
        $branches = Branch::all();
        $form_action = [
            'page_title' => 'Create New Product Order',
            'route' => route('product_orders.store'),
        ];
        return view('product_orders.form', compact('form_action', 'products', 'branches'));
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $expected_arrival_date = date('Y-m-d', strtotime(str_replace('-', '/', $input['expected_arrival_date'])));
        $response = ProductOrderController::create($input['product_id'], $input['branch_id'], $input['quantity'], $expected_arrival_date);
        $status = ($response['status_code'] == Response::HTTP_OK) ? 'success' : 'error';

        /* TODO :: Update quantity of product */

        return redirect(route('product_orders.index'))
            ->with($status, $response['message']);
    }

    public function show(ProductOrder $product_order)
    {
        return view('product_orders.show', compact('product_order'));
    }

    public function edit(ProductOrder $product_order)
    {
        $product_order->expected_arrival_date = date('m/d/Y', strtotime($product_order->expected_arrival_date));
        $products = Product::all();
        $branches = Branch::all();
        $form_action = [
            'page_title' => 'Update Product Order ID #' . $product_order->id,
            'route' => route('product_orders.update', ['product_order' => $product_order->id]),
        ];

        return view('product_orders.form', compact('form_action', 'product_order', 'products', 'branches'));
    }

    public function update(Request $request, ProductOrder $product_order)
    {
        $input = $request->all();
        $expected_arrival_date = date('Y-m-d', strtotime(str_replace('-', '/', $input['expected_arrival_date'])));

        $response = ProductOrderController::update($product_order->id, $input['product_id'], $input['branch_id'], $input['quantity'], $expected_arrival_date);
        $status = ($response['status_code'] == Response::HTTP_OK) ? 'success' : 'error';

        return redirect(route('product_orders.show', ['product_order' => $product_order->id]))
            ->with($status, $response['message']);
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
