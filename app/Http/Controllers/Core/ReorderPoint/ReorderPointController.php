<?php

namespace App\Http\Controllers\Core\ReorderPoint;

use App\Http\Controllers\Controller;
use App\Models\Branch\Branch;
use App\Models\Inventory\Inventory;
use App\Models\Product\Product;
use App\Models\Product\ProductSale;
use Illuminate\Http\Response;

class ReorderPointController extends Controller
{
    private static $LEAD_TIME = 7;

    public static $CODE_HAS_BELOW_THRESHOLD = 100;
    public static $CODE_NONE_BELOW_THRESHOLD = 101;

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
                if ($product_sale->quantity >= $usage_max) {
                    $usage_max = $product_sale->quantity;
                }

                $sale_quantity += $product_sale->quantity;
                $sale_count++;
            }

            if ($sale_count > 0)
                $usage_avg = ($sale_quantity / $sale_count);

            //            Log::debug('Sale Qty: ' . $sale_quantity);
            //            Log::debug('Sale Count: ' . $sale_count);

            //            Log::debug('Usage Max: ' . $usage_max);
            //            Log::debug('Usage Avg: ' . $usage_avg);

            $safety_stock = ($usage_max * self::$LEAD_TIME) - ($usage_avg * self::$LEAD_TIME);
            $reorder_point = ($usage_avg * self::$LEAD_TIME) + $safety_stock;

            //            Log::debug('Safety Stock: ' . $safety_stock);
            //            Log::debug('Reorder Point: ' . $reorder_point);

            $data = array();
            $data['reorder_point'] = $reorder_point;
            $data['needs_restock'] = (($inventory->quantity) < $reorder_point) ? true : false;
            $data['current_inventory'] = $inventory->quantity;

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

    public static function hasProductsBelowReorderPoints()
    {
        $response = array();

        $products = Product::all();
        foreach ($products as $key => $product) {
            $reorder_point_summary = self::calculateReorderPoint($product->id);

            $product->quantity = $reorder_point_summary['data']['current_inventory'];
            $product->reorder_point = $reorder_point_summary['data']['reorder_point'];

            if (!$reorder_point_summary['data']['needs_restock']) {
                $products->forget($key);
            }
        }

        if (count($products) > 0) {
            $data = array();
            $data['code'] = self::$CODE_HAS_BELOW_THRESHOLD;
            $data['products'] = $products;

            $response['data'] = $data;
            $response['message'] = 'Products below re-order points found.';
            $response['status_code'] = Response::HTTP_OK;
        } else {
            $data = array();
            $data['code'] = self::$CODE_NONE_BELOW_THRESHOLD;

            $response['data'] = $data;
            $response['message'] = 'No products below re-order points found.';
            $response['status_code'] = Response::HTTP_OK;
        }

        return $response;
    }
}
