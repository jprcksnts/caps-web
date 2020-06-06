<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Core\Product\ProductController;
use App\Models\Product\Product;
use App\Models\Product\ProductType;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ProductsController extends Controller
{
    public function index()
    {
        $table_headers = ['id', 'name', 'product type', 'code', 'quantity', ''];
        return view('products.index', compact('table_headers'));
    }

    public function create()
    {
        $product_types = ProductType::all();
        $form_action = [
            'page_title' => 'Create New Product',
            'route' => route('products.store'),
        ];
        return view('products.form', compact('form_action', 'product_types'));
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $response = ProductController::create($input['product_type_id'], $input['name'], $input['code'], $input['quantity']);
        $status = ($response['status_code'] == Response::HTTP_OK) ? 'success' : 'error';

        return redirect(route('products.index'))
            ->with($status, $response['message']);
    }

    public function edit(Product $product)
    {
        $product_types = ProductType::all();
        $form_action = [
            'page_title' => 'Update Product ID #' . $product->id,
            'route' => route('products.update', ['product' => $product->id]),
        ];

        return view('products.form', compact('form_action', 'product', 'product_types'));
    }

    public function update(Request $request, Product $product)
    {
        $input = $request->all();
        $response = ProductController::update($product->id, $input['product_type_id'], $input['name'], $input['code'], $input['quantity']);
        $status = ($response['status_code'] == Response::HTTP_OK) ? 'success' : 'error';

        return redirect(route('products.show', ['product' => $product->id]))
            ->with($status, $response['message']);
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function retrieveList()
    {
        $products = DB::table('products')
            ->select('products.id',
                'products.name',
                'products.code',
                'product_types.type',
                'products.quantity')
            ->leftJoin('product_types', 'products.product_type_id', '=', 'product_types.id');

        return DataTables::query($products)
            ->addColumn('action_column', function ($product) {
                $route = route('products.show', ['product' => $product->id]);
                return '<a href="' . $route . '" class="table-action"><i class="fas fa-chevron-right"></i></a>';
            })
            ->rawColumns(['action_column'])
            ->toJson();
    }
}
