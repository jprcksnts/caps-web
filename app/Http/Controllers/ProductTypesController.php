<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Core\Product\ProductTypeController;
use App\Models\Product\ProductType;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\Facades\DataTables;

class ProductTypesController extends Controller
{
    public function index()
    {
        $table_headers = ['id', 'type', 'updated at', ''];
        return view('product_types.index', compact('table_headers'));
    }

    public function create()
    {
        $form_action = [
            'page_title' => 'Create New Product Type',
            'route' => route('product_types.store'),
        ];
        return view('product_types.form', compact('form_action'));
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $response = ProductTypeController::create($input['type']);
        $status = ($response['status_code'] == Response::HTTP_OK) ? 'success' : 'error';

        return redirect(route('product_types.index'))
            ->with($status, $response['message']);
    }

    public function delete(ProductType $product_type)
    {
        $response = ProductTypeController::delete($product_type->id);
        $status = ($response['status_code'] == Response::HTTP_OK) ? 'success' : 'error';

        return redirect(route('product_types.index'))
            ->with($status, $response['message']);
    }

    public function edit(ProductType $product_type)
    {
        $form_action = [
            'page_title' => 'Update Product Type ID #' . $product_type->id,
            'route' => route('product_types.update', ['product_type' => $product_type->id]),
        ];

        return view('product_types.form', compact('form_action', 'product_type'));
    }

    public function update(Request $request, ProductType $product_type)
    {
        $input = $request->all();
        $response = ProductTypeController::update($product_type->id, $input['type']);
        $status = ($response['status_code'] == Response::HTTP_OK) ? 'success' : 'error';

        return redirect(route('product_types.show', ['product_type' => $product_type->id]))
            ->with($status, $response['message']);
    }

    public function show(ProductType $product_type)
    {
        return view('product_types.show', compact('product_type'));
    }

    public function retrieveList()
    {
        $product_types = ProductType::query();

        return DataTables::eloquent($product_types)
            ->addColumn('action_column', function ($product_type) {
                $route = route('product_types.show', ['product_type' => $product_type->id]);
                return '<a href="' . $route . '" class="table-action"><i class="fas fa-chevron-right"></i></a>';
            })
            ->rawColumns(['action_column'])
            ->toJson();
    }
}
