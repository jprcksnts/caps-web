<?php

namespace App\Imports;

use App\Http\Controllers\Core\Inventory\InventoryController;
use App\Http\Controllers\Core\inventory\InventoryMovementController;
use App\Http\Controllers\Core\Product\ProductSaleController;
use App\Models\Branch\Branch;
use App\Models\Inventory\Inventory;
use App\Models\Inventory\InventoryMovement;
use App\Models\Product\Product;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ProductSalesImport implements ToCollection, WithHeadingRow
{
    public $data;

    public function collection(Collection $rows)
    {
        try {
            $failed_uploads = 0;

            foreach ($rows as $row) {
                $branch_code = $row['branch_code'];
                $product_code = $row['product_code'];
                $quantity = $row['quantity'];
                $date = Date::excelToDateTimeObject($row['date'])->format('Y-m-d');

                $branch = Branch::where('code', $branch_code)->first();
                $product = Product::where('code', $product_code)->first();

                if ($branch && $product) {
                    /* Create product sale model */
                    $response = ProductSaleController::create($product->id, $branch->id, $quantity, $date);

                    /* Update inventory movement if product sale create success */
                    if ($response['status_code'] == Response::HTTP_OK) {
                        $inventory = Inventory::where('branch_id', Branch::$WAREHOUSE)
                            ->where('product_id', $product->id)->first();
                        $updated_quantity = $inventory->quantity - $quantity;

                        InventoryController::update($inventory->id, $updated_quantity);
                        InventoryMovementController::create($response['data']['product_sale']['id'], InventoryMovement::$sale, $quantity, $updated_quantity);
                    } else {
                        $failed_uploads++;
                    }
                }
            }

            if ($failed_uploads <= 0) {
                $this->data = ['status' => 'success', 'message' => 'Data import is completed successfully.'];
            } else {
                $this->data = ['status' => 'error', 'message' => 'An error occurred during import, please check uploaded document and try again.'];
            }

        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            Log::error($exception->getTraceAsString());
            $this->data = ['status' => 'error', 'message' => 'An error occurred during import, please check uploaded document and try again.'];
        }
    }
}
