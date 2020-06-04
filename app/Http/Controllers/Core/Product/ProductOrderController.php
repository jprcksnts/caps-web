<?php

namespace App\Http\Controllers\Core\Product;

use App\Http\Controllers\Controller;
use App\Models\Product\ProductOrder;
use Illuminate\Database\QueryException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductOrderController extends Controller
{
    public static function create($product_id, $quantity, $expected_arrival_date)
    {
        $response = array();

        try {
            DB::beginTransaction();

            $product_order = new ProductOrder();
            $product_order->product_id = $product_id;
            $product_order->quantity = $quantity;
            $product_order->expected_arrival_date = $expected_arrival_date;
            $product_order->save();

            DB::commit();

            $data = array();
            $data['product_order'] = $product_order;

            $response['data'] = $data;
            $response['message'] = 'Product order successfully created.';
            $response['status_code'] = Response::HTTP_OK;
        } catch (QueryException $exception) {
            Log::error($exception->getMessage());
            Log::error($exception->getTraceAsString());

            $error_code = $exception->errorInfo[1];
            Log::error($error_code);

            $error = array();
            $error['message'] = 'Query exception occurred.';

            $response['error'] = $error;
            $response['message'] = 'Failed to create product order.';
            $response['status_code'] = Response::HTTP_BAD_REQUEST;
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            Log::error($exception->getTraceAsString());

            $error = array();
            $error['message'] = 'Unknown error occurred.';

            $response['error'] = $error;
            $response['message'] = 'Failed to create product order.';
            $response['status_code'] = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return $response;
    }

    public static function update($product_order_id, $product_id, $quantity, $expected_arrival_date)
    {
        $response = array();

        try {
            $product_order = ProductOrder::where('id', $product_order_id)->first();

            if ($product_order != null) {
                DB::beginTransaction();

                $product_order->product_id = $product_id;
                $product_order->quantity = $quantity;
                $product_order->expected_arrival_date = $expected_arrival_date;
                $product_order->save();

                DB::commit();

                $data = array();
                $data['product_order'] = $product_order;

                $response['data'] = $data;
                $response['message'] = 'Product order successfully updated.';
                $response['status_code'] = Response::HTTP_OK;
            } else {
                $error = array();
                $error['message'] = 'Product order not found.';

                $response['error'] = $error;
                $response['message'] = 'Failed to update product order.';
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
            $response['message'] = 'Failed to update product order.';
            $response['status_code'] = Response::HTTP_BAD_REQUEST;
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            Log::error($exception->getTraceAsString());

            $error = array();
            $error['message'] = 'Unknown error occurred.';

            $response['error'] = $error;
            $response['message'] = 'Failed to update product order.';
            $response['status_code'] = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return $response;
    }

    public static function delete($product_order_id)
    {
        $response = array();

        try {
            $product_order = ProductOrder::where('id', $product_order_id)->first();

            if ($product_order != null) {
                // if product order exists
                DB::beginTransaction();

                $product_order->delete();

                DB::commit();

                $response['message'] = 'Product order successfully deleted.';
                $response['status_code'] = Response::HTTP_OK;
            } else {
                // if product order does not exist
                $error = array();
                $error['message'] = 'Product order not found.';

                $response['error'] = $error;
                $response['message'] = 'Failed to delete product order.';
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
            $response['message'] = 'Failed to delete product order.';
            $response['status_code'] = Response::HTTP_BAD_REQUEST;
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            Log::error($exception->getTraceAsString());

            $error = array();
            $error['message'] = 'Unknown error occurred.';

            $response['error'] = $error;
            $response['message'] = 'Failed to delete product order.';
            $response['status_code'] = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return $response;
    }
}
