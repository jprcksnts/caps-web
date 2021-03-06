<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Core\Inventory\InventoryController;
use App\Http\Controllers\Core\inventory\InventoryMovementController;
use App\Http\Controllers\Core\Product\ProductSaleController;
use App\Http\Controllers\Core\ReorderPoint\ReorderPointController;
use App\Models\Branch\Branch;
use App\Models\Inventory\Inventory;
use App\Models\Inventory\InventoryMovement;
use App\Models\Product\Product;
use App\Models\Product\ProductSale;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class ProductSalesController extends Controller
{
    public function index()
    {
        $table_headers = ['id', 'product', 'branch', 'quantity', 'transaction date', ''];

        return view('product_sales.index', compact('table_headers'));
    }

    public function create()
    {
        $products = Product::all();
        $branches = Branch::whereNotIn('id', [Branch::$WAREHOUSE])->get();

        $form_action = [
            'page_title' => 'Create New Product Sale',
            'route' => route('product_sales.store'),
        ];
        return view('product_sales.form', compact('form_action', 'products', 'branches'));
    }

    public function store(Request $request)
    {
        Log::debug($request->all());
        $input = $request->all();
        $response = ProductSaleController::create($input['product_id'], $input['branch_id'], $input['quantity']);
        $status = ($response['status_code'] == Response::HTTP_OK) ? 'success' : 'error';

        /* Inventory Movement */
        /* Declaring initial quantity on default main branch */
        $inventory = Inventory::where('branch_id', Branch::$WAREHOUSE)
            ->where('product_id', $input['product_id'])->first();
        Log::debug($inventory);
        $updated_quantity = $inventory->quantity - $request['quantity'];

        InventoryController::update($inventory->id, $updated_quantity);
        InventoryMovementController::create($response['data']['product_sale']['id'], InventoryMovement::$sale, $request['quantity'], $updated_quantity);

        $reorder_point_response = ReorderPointController::hasProductsBelowReorderPoints();
        if ($reorder_point_response['status_code'] == Response::HTTP_OK) {
            if ($reorder_point_response['data']['code'] == ReorderPointController::$CODE_HAS_BELOW_THRESHOLD) {
                session()->flash('has_product_below_threshold', true);
            }
        }

        return redirect(route('product_sales.index'))
            ->with($status, $response['message']);
    }

    public function delete(ProductSale $product_sale)
    {
        $inventory = Inventory::where('branch_id', Branch::$WAREHOUSE)
            ->where('product_id', $product_sale->product_id)->first();

        /* Reverse Inventory Movement */
        $updated_quantity = $inventory->quantity + $product_sale->quantity;

        InventoryController::update($inventory->id, $updated_quantity);
        InventoryMovementController::create($product_sale->id, InventoryMovement::$sale, $product_sale->quantity, $updated_quantity);

        $response = ProductSaleController::delete($product_sale->id);
        $status = ($response['status_code'] == Response::HTTP_OK) ? 'success' : 'error';

        return redirect(route('product_sales.index'))
            ->with($status, $response['message']);
    }

    public function show(ProductSale $product_sale)
    {
        return view('product_sales.show', compact('product_sale'));
    }

    public function edit(ProductSale $product_sale)
    {
        $products = Product::all();
        $branches = Branch::all();
        $form_action = [
            'page_title' => 'Update Product Sale ID #' . $product_sale->id,
            'route' => route('product_sales.update', ['product_sale' => $product_sale->id]),
        ];

        return view('product_sales.form', compact('form_action', 'product_sale', 'products', 'branches'));
    }

    public function update(Request $request, ProductSale $product_sale)
    {
        $input = $request->all();
        $response = ProductSaleController::update($product_sale->id, $input['product_id'], $input['branch_id'], $input['quantity']);
        $status = ($response['status_code'] == Response::HTTP_OK) ? 'success' : 'error';

        return redirect(route('product_sales.show', ['product_sale' => $product_sale->id]))
            ->with($status, $response['message']);
    }

    public function retrieveList()
    {
        $product_sales = DB::table('product_sales')
            ->select('product_sales.id',
                'products.name as product_name',
                'branches.name as branch_name',
                'product_sales.quantity',
                'product_sales.created_at')
            ->leftJoin('products', 'product_sales.product_id', '=', 'products.id')
            ->leftJoin('branches', 'product_sales.branch_id', '=', 'branches.id')
            ->where('product_sales.deleted_at', null);

        return DataTables::query($product_sales)
            ->addColumn('action_column', function ($product_sale) {
                $route = route('product_sales.show', ['product_sale' => $product_sale->id]);
                return '<a href="' . $route . '" class="table-action"><i class="fas fa-chevron-right"></i></a>';
            })
            ->rawColumns(['action_column'])
            ->toJson();
    }
}
