<?php

namespace App\Http\Controllers\Core\Product;

use App\Http\Controllers\Controller;
use App\Models\Product\ProductType;
use Illuminate\Database\QueryException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductTypeController extends Controller
{
    public static function create($type)
    {
        $response = array();

        try {
            DB::beginTransaction();

            $product_type = new ProductType();
            $product_type->type = $type;
            $product_type->save();

            DB::commit();

            $data = array();
            $data['product_type'] = $product_type;

            $response['data'] = $data;
            $response['message'] = 'Product type successfully created.';
            $response['status_code'] = Response::HTTP_OK;
        } catch (QueryException $exception) {
            Log::error($exception->getMessage());
            Log::error($exception->getTraceAsString());

            $error_code = $exception->errorInfo[1];
            Log::error($error_code);

            if ($error_code == 1062) {
                $error = array();
                $error['message'] = 'Product type already exists.';

                $response['error'] = $error;
                $response['message'] = 'Failed to create product type.';
                $response['status_code'] = Response::HTTP_BAD_REQUEST;
            } else {
                $error = array();
                $error['message'] = 'Query exception occurred.';

                $response['error'] = $error;
                $response['message'] = 'Failed to create product type.';
                $response['status_code'] = Response::HTTP_BAD_REQUEST;
            }
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            Log::error($exception->getTraceAsString());

            $error = array();
            $error['message'] = 'Unknown error occurred.';

            $response['error'] = $error;
            $response['message'] = 'Failed to create product type.';
            $response['status_code'] = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return $response;
    }

    public static function update($product_type_id, $type)
    {
        $response = array();

        try {
            $product_type = ProductType::where('id', $product_type_id)->first();

            if ($product_type != null) {
                // if product type exists
                DB::beginTransaction();

                $product_type->type = $type;
                $product_type->save();

                DB::commit();

                $data = array();
                $data['product_type'] = $product_type;

                $response['data'] = $data;
                $response['message'] = 'Product type successfully updated.';
                $response['status_code'] = Response::HTTP_OK;
            } else {
                // if product type does not exist
                $error = array();
                $error['message'] = 'Product type not found.';

                $response['error'] = $error;
                $response['message'] = 'Failed to update product type.';
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
            $response['message'] = 'Failed to update product type.';
            $response['status_code'] = Response::HTTP_BAD_REQUEST;
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            Log::error($exception->getTraceAsString());

            $error = array();
            $error['message'] = 'Unknown error occurred.';

            $response['error'] = $error;
            $response['message'] = 'Failed to update product type.';
            $response['status_code'] = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return $response;
    }

    public static function delete($product_type_id)
    {
        $response = array();

        try {
            $product_type = ProductType::where('id', $product_type_id)->first();

            if ($product_type != null) {
                // if product type exists
                DB::beginTransaction();

                $product_type->delete();

                DB::commit();

                $response['message'] = 'Product type successfully deleted.';
                $response['status_code'] = Response::HTTP_OK;
            } else {
                // if product type does not exist

                $error = array();
                $error['message'] = 'Product type not found.';

                $response['error'] = $error;
                $response['message'] = 'Failed to delete product type.';
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
            $response['message'] = 'Failed to update product type.';
            $response['status_code'] = Response::HTTP_BAD_REQUEST;
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            Log::error($exception->getTraceAsString());

            $error = array();
            $error['message'] = 'Unknown error occurred.';

            $response['error'] = $error;
            $response['message'] = 'Failed to update product type.';
            $response['status_code'] = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return $response;
    }
}
