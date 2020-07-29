<?php

namespace App\Http\Controllers\Core\ReorderPoint;

use App\Http\Controllers\Controller;
use App\Models\Branch\Branch;
use App\Models\Inventory\Inventory;
use App\Models\Product\ProductSale;
use Illuminate\Http\Response;

class ReorderPointController extends Controller
{
    private static $LEAD_TIME = 7;

    public static function calculateReorderPoint($product_id)
    {
        $response = array();

        $inventory = Inventory::where('product_id', $product_id)
            ->where('branch_id', Branch::$WAREHOUSE)
            ->first();

        if ($inventory != null) {
            // product exists

            $product_sales = ProductSale::where('product_id', $product_id)
                ->orderBy('created_at', 'desc')
                ->get();

            $usage_max = 0;
            $usage_avg = 0;

            $sale_quantity = 0;
            $sale_count = 0;
            foreach ($product_sales as $product_sale) {
                if ($usage_max >= $product_sale->quantity) {
                    $usage_max = $product_sale->quantity;
                }

                $sale_quantity += $product_sale->quantity;
                $sale_count++;
            }

            if ($sale_count > 0)
                $usage_avg = ($sale_quantity / $sale_count);

            $safety_stock = ($usage_max * self::$LEAD_TIME) - ($usage_avg * self::$LEAD_TIME);
            $reorder_point = ($usage_avg * self::$LEAD_TIME) + $safety_stock;

            $data = array();
            $data['reorder_point'] = $reorder_point;
            $data['needs_restock'] = (($inventory->quantity) < $reorder_point) ? true : false;

            $response['data'] = $data;
            $response['message'] = 'Reorder point calculation successful.';
            $response['status_code'] = Response::HTTP_OK;
        } else {
            // product not found

            $error = array();
            $error['message'] = 'Product not found.';

            $response['error'] = $error;
            $response['message'] = 'Failed to calculate reorder points.';
            $response['status_code'] = Response::HTTP_BAD_REQUEST;
        }

        return $response;
    }
}
