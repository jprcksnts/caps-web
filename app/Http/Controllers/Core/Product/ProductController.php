<?php

namespace App\Http\Controllers\Core\Product;

use App\Http\Controllers\Controller;
use App\Models\Product\Product;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public static function getProductByUUID($uuid)
    {
        $response = array();

        try {
            $product = Product::where('uuid', $uuid)->first();

            if ($product != null) {
                $data = array();
                $data['product'] = $product;

                $response['data'] = $data;
                $response['message'] = 'Product found.';
                $response['status_code'] = Response::HTTP_OK;
            } else {
                $error = array();
                $error['message'] = 'Invalid product UUID.';

                $response['error'] = $error;
                $response['message'] = 'Product not found.';
                $response['error'] = Response::HTTP_BAD_REQUEST;
            }
        } catch (QueryException $exception) {
            Log::error($exception->getMessage());
            Log::error($exception->getTraceAsString());

            $error_code = $exception->errorInfo[1];
            Log::error($error_code);

            $error = array();
            $error['message'] = 'Query exception occurred.';

            $response['error'] = $error;
            $response['message'] = 'Failed to find product.';
            $response['status_code'] = Response::HTTP_BAD_REQUEST;
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            Log::error($exception->getTraceAsString());

            $error = array();
            $error['message'] = 'Unknown error occurred.';

            $response['error'] = $error;
            $response['message'] = 'Failed to find product.';
            $response['status_code'] = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return $response;
    }

    public static function create($product_type_id, $name, $code, $quantity)
    {
        $response = array();

        try {
            DB::beginTransaction();

            $product = new Product();
            $product->product_type_id = $product_type_id;
            $product->name = $name;
            $product->uuid = (string)Str::uuid();
            $product->code = $code;
            $product->quantity = $quantity;
            $product->save();

            $file_name = $product->uuid . '.svg';
            $image = \QrCode::format('svg')
                ->size(512)->generate($product->uuid, public_path() . '/generated_code/' . $file_name);

            DB::commit();

            $data = array();
            $data['product'] = $product;

            $response['data'] = $data;
            $response['message'] = 'Product successfully created.';
            $response['status_code'] = Response::HTTP_OK;
        } catch (QueryException $exception) {
            Log::error($exception->getMessage());
            Log::error($exception->getTraceAsString());

            $error_code = $exception->errorInfo[1];
            Log::error($error_code);

            $error = array();
            $error['message'] = 'Query exception occurred.';

            $response['error'] = $error;
            $response['message'] = 'Failed to create product.';
            $response['status_code'] = Response::HTTP_BAD_REQUEST;
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            Log::error($exception->getTraceAsString());

            $error = array();
            $error['message'] = 'Unknown error occurred.';

            $response['error'] = $error;
            $response['message'] = 'Failed to create product.';
            $response['status_code'] = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return $response;
    }

    public static function update($product_id, $product_type_id, $name, $code, $quantity)
    {
        $response = array();

        try {
            $product = Product::where('id', $product_id)->first();

            if ($product != null) {
                // if product exists
                DB::beginTransaction();

                $product->product_type_id = $product_type_id;
                $product->name = $name;
                $product->code = $code;
                $product->quantity = $quantity;
                $product->save();

                DB::commit();

                $data = array();
                $data['product'] = $product;

                $response['data'] = $data;
                $response['message'] = 'Product successfully updated.';
                $response['status_code'] = Response::HTTP_OK;
            } else {
                // if product does not exist
                $error = array();
                $error['message'] = 'Product not found.';

                $response['error'] = $error;
                $response['message'] = 'Failed to update product.';
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
            $response['message'] = 'Failed to update product.';
            $response['status_code'] = Response::HTTP_BAD_REQUEST;
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            Log::error($exception->getTraceAsString());

            $error = array();
            $error['message'] = 'Unknown error occurred.';

            $response['error'] = $error;
            $response['message'] = 'Failed to update product.';
            $response['status_code'] = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return $response;
    }

    public static function delete($product_id)
    {
        $response = array();

        try {
            $product = Product::where('id', $product_id)->first();

            if ($product != null) {
                // if product exists
                DB::beginTransaction();

                $product->delete();

                DB::commit();

                $response['message'] = 'Product successfully deleted.';
                $response['status_code'] = Response::HTTP_OK;
            } else {
                // if product does not exist
                $error = array();
                $error['message'] = 'Product not found.';

                $response['error'] = $error;
                $response['message'] = 'Failed to delete product.';
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
            $response['message'] = 'Failed to delete product.';
            $response['status_code'] = Response::HTTP_BAD_REQUEST;
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            Log::error($exception->getTraceAsString());

            $error = array();
            $error['message'] = 'Unknown error occurred.';

            $response['error'] = $error;
            $response['message'] = 'Failed to delete product.';
            $response['status_code'] = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return $response;
    }
}
