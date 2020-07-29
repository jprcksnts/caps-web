<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Core\Inventory\InventoryController;
use App\Http\Controllers\Core\inventory\InventoryMovementController;
use App\Http\Controllers\Core\Product\ProductController;
use App\Http\Controllers\Core\Product\ProductOrderController;
use App\Http\Controllers\Core\ReorderPoint\ReorderPointController;
use App\Models\Branch\Branch;
use App\Models\Inventory\InventoryMovement;
use App\Models\Product\Product;
use App\Models\Product\ProductType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ProductsController extends Controller
{
    public function index()
    {
        $table_headers = ['id', 'name', 'product type', 'code', ''];
        return view('products.index', compact('table_headers'));
    }

    public function create()
    {
        $product_types = ProductType::all();
        $form_action = [
            'action' => 'create',
            'page_title' => 'Create New Product',
            'route' => route('products.store'),
        ];
        return view('products.form', compact('form_action', 'product_types'));
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $response = ProductController::create($input['product_type_id'], $input['name'], $input['code']);

        if ($request['quantity'] > 0) {
            $new_product = $response['data']['product'];
            $default_branch = Branch::$WAREHOUSE;
            $product_order = ProductOrderController::create($new_product->id, $default_branch, $request['quantity'], Carbon::now());

            /* Inventory Movement */
            /* Declaring initial quantity on default main branch */
            InventoryController::create($default_branch, $new_product->id, $request['quantity']);
            InventoryMovementController::create($product_order['data']['product_order']['id'], InventoryMovement::$order, $request['quantity'], $request['quantity']);
        }

        $status = ($response['status_code'] == Response::HTTP_OK) ? 'success' : 'error';

        return redirect(route('products.index'))
            ->with($status, $response['message']);
    }

    public function edit(Product $product)
    {
        $product_types = ProductType::all();
        $form_action = [
            'action' => 'edit',
            'page_title' => 'Update Product ID #' . $product->id,
            'route' => route('products.update', ['product' => $product->id]),
        ];

        return view('products.form', compact('form_action', 'product', 'product_types'));
    }

    public function update(Request $request, Product $product)
    {
        $input = $request->all();
        $response = ProductController::update($product->id, $input['product_type_id'], $input['name'], $input['code']);
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
                'product_types.type')
            ->leftJoin('product_types', 'products.product_type_id', '=', 'product_types.id');

        return DataTables::query($products)
            ->addColumn('action_column', function ($product) {
                $route = route('products.show', ['product' => $product->id]);
                return '<a href="' . $route . '" class="table-action"><i class="fas fa-chevron-right"></i></a>';
            })
            ->rawColumns(['action_column'])
            ->toJson();
    }

    public function retrieveReorderPoints()
    {
        $products = Product::all();
        foreach ($products as $key => $product) {
            $reorder_point_summary = ReorderPointController::calculateReorderPoint($product->id);

            $product->quantity = $reorder_point_summary['data']['current_inventory'];
            $product->reorder_point = $reorder_point_summary['data']['reorder_point'];

            if (!$reorder_point_summary['data']['needs_restock']) {
                $products->forget($key);
            }
        }

        return DataTables::collection($products)->toJson();
    }
}
