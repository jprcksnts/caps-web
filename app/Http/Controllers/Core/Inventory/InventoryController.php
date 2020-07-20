<?php

namespace App\Http\Controllers\Core\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Inventory\Inventory;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InventoryController extends Controller
{
    public static function create($branch_id, $product_id, $quantity)
    {
        $response = array();

        try {
            DB::beginTransaction();

            $inventory = Inventory::where('branch_id', $branch_id)
                ->where('product_id', $product_id)->first();

            if ($inventory == null) {
                // inventory item does not exist

                $inventory = new Inventory();
                $inventory->branch_id = $branch_id;
                $inventory->product_id = $product_id;
                $inventory->quantity = $quantity;
                $inventory->save();

                DB::commit();

                $data = array();
                $data['inventory'] = $inventory;

                $response['data'] = $data;
                $response['message'] = 'Inventory item successfully created.';
                $response['status_code'] = Response::HTTP_OK;
            } else {
                // inventory item already exists

                $error = array();
                $error['message'] = 'Inventory item already exists.';

                $response['error'] = $error;
                $response['message'] = 'Failed to create inventory item.';
                $response['status_code'] = Response::HTTP_BAD_REQUEST;
            }
        } catch (QueryException $exception) {
            Log::error($exception->getMessage());
            Log::error($exception->getTraceAsString());

            $error_code = $exception->errorInfo[1];
            Log::error($error_code);

            $error = array();
            $error['message'] = 'Query exception occurred.';

            $response['error'] = $error;
            $response['message'] = 'Failed to create inventory item.';
            $response['status_code'] = Response::HTTP_BAD_REQUEST;
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            Log::error($exception->getTraceAsString());

            $error = array();
            $error['message'] = 'Unknown error occurred.';

            $response['error'] = $error;
            $response['message'] = 'Failed to create inventory item.';
            $response['status_code'] = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return $response;
    }

    public static function update($inventory_id, $quantity)
    {
        $response = array();

        try {
            DB::beginTransaction();

            $inventory = Inventory::where('id', $inventory_id)->first();

            if ($inventory != null) {
                // inventory item exists

                $inventory->quantity = $quantity;
                $inventory->save();

                DB::commit();

                $data = array();
                $data['inventory'] = $inventory;

                $response['data'] = $data;
                $response['message'] = 'Inventory item successfully updated.';
                $response['status_code'] = Response::HTTP_OK;
            } else {
                // inventory item already exists

                $error = array();
                $error['message'] = 'Inventory item not found.';

                $response['error'] = $error;
                $response['message'] = 'Failed to update inventory item.';
                $response['status_code'] = Response::HTTP_BAD_REQUEST;
            }
        } catch (QueryException $exception) {
            Log::error($exception->getMessage());
            Log::error($exception->getTraceAsString());

            $error_code = $exception->errorInfo[1];
            Log::error($error_code);

            $error = array();
            $error['message'] = 'Query exception occurred.';

            $response['error'] = $error;
            $response['message'] = 'Failed to update inventory item.';
            $response['status_code'] = Response::HTTP_BAD_REQUEST;
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            Log::error($exception->getTraceAsString());

            $error = array();
            $error['message'] = 'Unknown error occurred.';

            $response['error'] = $error;
            $response['message'] = 'Failed to update inventory item.';
            $response['status_code'] = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return $response;
    }
}
