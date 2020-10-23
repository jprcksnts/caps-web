<?php

namespace App\Http\Controllers\API\v1\Product;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Core\Product\ProductController;

class ApiProductController extends Controller
{
    public function getProductByUUID($uuid)
    {
        $response = ProductController::getProductByUUID($uuid);
        return response()->json($response);
    }
}
