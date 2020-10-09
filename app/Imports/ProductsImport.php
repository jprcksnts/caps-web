<?php

namespace App\Imports;

use App\Http\Controllers\Core\Inventory\InventoryController;
use App\Http\Controllers\Core\inventory\InventoryMovementController;
use App\Http\Controllers\Core\Product\ProductController;
use App\Http\Controllers\Core\Product\ProductOrderController;
use App\Models\Branch\Branch;
use App\Models\Inventory\InventoryMovement;
use App\Models\Product\ProductType;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        try {
            $default_branch = Branch::$WAREHOUSE;

            foreach ($rows as $row) {
                $product_name = $row['product_name'];
                $product_type = $row['product_type'];
                $product_code = $row['product_code'];
                $initial_quantity = $row['initial_quantity'];

                $product_type = ProductType::where('type', $product_type)->first();

                if ($product_type) {
                    /* Create product model */
                    $response = ProductController::create($product_type->id, $product_name, $product_code);

                    /* Declare initial quantity and movement if product create success */
                    if ($response['status_code'] == Response::HTTP_OK && $initial_quantity > 0) {
                        $new_product = $response['data']['product'];

                        $product_order = ProductOrderController::create($new_product->id, $default_branch, $initial_quantity, Carbon::now());
                        InventoryController::create($default_branch, $new_product->id, $initial_quantity);
                        InventoryMovementController::create($product_order['data']['product_order']['id'], InventoryMovement::$order, $initial_quantity, $initial_quantity);
                    }
                }
            }

        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            Log::error($exception->getTraceAsString());
        }
    }
}
