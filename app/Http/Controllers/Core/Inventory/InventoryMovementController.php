<?php

namespace App\Http\Controllers\Core\inventory;

use App\Http\Controllers\Controller;
use App\Models\Inventory\InventoryMovement;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InventoryMovementController extends Controller
{
    public static function create($tx_id, $type, $quantity, $r_quantity, $use_db_transaction = true)
    {
        $response = array();

        try {
            if ($use_db_transaction)
                DB::beginTransaction();

            $inventory_movement = new InventoryMovement();
            $inventory_movement->tx_id = $tx_id;
            $inventory_movement->type = $type;
            $inventory_movement->quantity = $quantity;
            $inventory_movement->r_quantity = $r_quantity;
            $inventory_movement->save();

            if ($use_db_transaction)
                DB::commit();

            $data = array();
            $data['inventory_movement'] = $inventory_movement;

            $response['data'] = $data;
            $response['message'] = 'Inventory movement successfully created.';
            $response['status_code'] = Response::HTTP_OK;
        } catch (QueryException $exception) {
            Log::error($exception->getMessage());
            Log::error($exception->getTraceAsString());

            $error_code = $exception->errorInfo[1];
            Log::error($error_code);

            $error = array();
            $error['message'] = 'Query exception occurred.';

            $response['error'] = $error;
            $response['message'] = 'Failed to create inventory movement.';
            $response['status_code'] = Response::HTTP_BAD_REQUEST;
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            Log::error($exception->getTraceAsString());

            $error = array();
            $error['message'] = 'Unknown error occurred.';

            $response['error'] = $error;
            $response['message'] = 'Failed to create inventory movement.';
            $response['status_code'] = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return $response;
    }
}
