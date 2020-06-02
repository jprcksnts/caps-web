<?php

namespace App\Http\Controllers\Core\Product;

use App\Http\Controllers\Controller;
use App\Models\Product\ProductSale;
use Illuminate\Database\QueryException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductSaleController extends Controller
{
    public static function create($product_id, $branch_id, $quantity)
    {
        $response = array();

        try {
            DB::beginTransaction();

            $product_sale = new ProductSale();
            $product_sale->product_id = $product_id;
            $product_sale->branch_id = $branch_id;
            $product_sale->quantity = $quantity;
            $product_sale->save();

            DB::commit();

            $data = array();
            $data['product_sale'] = $product_sale;

            $response['data'] = $data;
            $response['message'] = 'Product sale successfully created.';
            $response['status_code'] = Response::HTTP_OK;
        } catch (QueryException $exception) {
            Log::error($exception->getMessage());
            Log::error($exception->getTraceAsString());

            $error_code = $exception->errorInfo[1];
            Log::error($error_code);

            $error = array();
            $error['message'] = 'Query exception occurred.';

            $response['error'] = $error;
            $response['message'] = ' Failed to create product sale.';
            $response['status_code'] = Response::HTTP_BAD_REQUEST;
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            Log::error($exception->getTraceAsString());

            $error = array();
            $error['message'] = 'Unknown error occurred.';

            $response['error'] = $error;
            $response['message'] = ' Failed to create product sale.';
            $response['status_code'] = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return $response;
    }

    public static function update($product_sale_id, $product_id, $branch_id, $quantity)
    {
        $response = array();

        try {
            $product_sale = ProductSale::where('id', $product_sale_id)->first();

            if ($product_sale != null) {
                // if product sale exists
                DB::beginTransaction();

                $product_sale->product_id = $product_id;
                $product_sale->branch_id = $branch_id;
                $product_sale->quantity = $quantity;
                $product_sale->save();

                DB::commit();

                $data = array();
                $data['product_sale'] = $product_sale;

                $response['data'] = $data;
                $response['message'] = 'Product sale successfully updated.';
                $response['status_code'] = Response::HTTP_OK;
            } else {
                // if product sale does not exist
                $error = array();
                $error['message'] = 'Product sale not found.';

                $response['error'] = $error;
                $response['message'] = 'Failed to update product sale.';
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
            $response['message'] = ' Failed to update product sale.';
            $response['status_code'] = Response::HTTP_BAD_REQUEST;
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            Log::error($exception->getTraceAsString());

            $error = array();
            $error['message'] = 'Unknown error occurred.';

            $response['error'] = $error;
            $response['message'] = ' Failed to update product sale.';
            $response['status_code'] = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return $response;
    }

    public static function delete($product_sale_id)
    {
        $response = array();

        $product_sale = ProductSale::where('id', $product_sale_id)->first();

        try {
            if ($product_sale != null) {
                // if product sale exists
                DB::beginTransaction();

                $product_sale->delete();

                DB::commit();

                $response['message'] = 'Product sale successfully deleted.';
                $response['status_code'] = Response::HTTP_OK;
            } else {
                // if product sale does not exist
                $error = array();
                $error['message'] = 'Product sale not found.';

                $response['error'] = $error;
                $response['message'] = 'Failed to delete product sale.';
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
            $response['message'] = ' Failed to delete product sale.';
            $response['status_code'] = Response::HTTP_BAD_REQUEST;
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            Log::error($exception->getTraceAsString());

            $error = array();
            $error['message'] = 'Unknown error occurred.';

            $response['error'] = $error;
            $response['message'] = ' Failed to delete product sale.';
            $response['status_code'] = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return $response;
    }
}
