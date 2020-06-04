<?php

namespace App\Http\Controllers\Core\Branch;

use App\Http\Controllers\Controller;
use App\Models\Branch\Branch;
use Illuminate\Database\QueryException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BranchController extends Controller
{
    public static function create($name, $address, $city)
    {
        $response = array();

        try {
            DB::beginTransaction();

            $branch = new Branch();
            $branch->name = $name;
            $branch->address = $address;
            $branch->city = $city;
            $branch->save();

            DB::commit();

            $data = array();
            $data['branch'] = $branch;

            $response['data'] = $data;
            $response['message'] = 'Branch successfully created.';
            $response['status_code'] = Response::HTTP_OK;
        } catch (QueryException $exception) {
            Log::error($exception->getMessage());
            Log::error($exception->getTraceAsString());

            $error_code = $exception->errorInfo[1];
            Log::error($error_code);

            if ($error_code == 1062) {
                $error = array();
                $error['message'] = 'Branch already exists.';

                $response['error'] = $error;
                $response['message'] = 'Failed to create branch.';
                $response['status_code'] = Response::HTTP_BAD_REQUEST;
            } else {
                $error = array();
                $error['message'] = 'Query exception occurred.';

                $response['error'] = $error;
                $response['message'] = 'Failed to create branch.';
                $response['status_code'] = Response::HTTP_BAD_REQUEST;
            }
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            Log::error($exception->getTraceAsString());

            $error = array();
            $error['message'] = 'Unknown error occurred.';

            $response['error'] = $error;
            $response['message'] = 'Failed to create branch.';
            $response['status_code'] = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return $response;
    }

    public static function update($branch_id, $name, $address, $city)
    {
        $response = array();

        try {
            $branch = Branch::where('id', $branch_id)->first();

            if ($branch != null) {
                // if branch exists
                DB::beginTransaction();

                $branch->name = $name;
                $branch->address = $address;
                $branch->city = $city;
                $branch->save();

                DB::commit();

                $data = array();
                $data['branch'] = $branch;

                $response['data'] = $data;
                $response['message'] = 'Branch successfully updated.';
                $response['status_code'] = Response::HTTP_OK;
            } else {
                // if branch does not exist
                $error = array();
                $error['message'] = 'Branch not found.';

                $response['error'] = $error;
                $response['message'] = 'Failed to update branch.';
                $response['status_code'] = Response::HTTP_BAD_REQUEST;
            }
        } catch (QueryException $exception) {
            Log::error($exception->getMessage());
            Log::error($exception->getTraceAsString());

            $error_code = $exception->errorInfo[1];
            Log::error($error_code);

            if ($error_code == 1062) {
                $error = array();
                $error['message'] = 'Branch already exists.';

                $response['error'] = $error;
                $response['message'] = 'Failed to update branch.';
                $response['status_code'] = Response::HTTP_BAD_REQUEST;
            } else {
                $error = array();
                $error['message'] = 'Query exception occurred.';

                $response['error'] = $error;
                $response['message'] = 'Failed to update branch.';
                $response['status_code'] = Response::HTTP_BAD_REQUEST;
            }
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            Log::error($exception->getTraceAsString());

            $error = array();
            $error['message'] = 'Unknown error occurred.';

            $response['error'] = $error;
            $response['message'] = 'Failed to update branch.';
            $response['status_code'] = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return $response;
    }

    public static function delete($branch_id)
    {
        $response = array();

        try {
            $branch = Branch::where('id', $branch_id)->first();

            if ($branch != null) {
                // if branch exists
                DB::beginTransaction();

                $branch->delete();

                DB::commit();

                $response['message'] = 'Branch successfully deleted.';
                $response['status_code'] = Response::HTTP_OK;
            } else {
                // if branch does not exist
                $error = array();
                $error['message'] = 'Branch not found.';

                $response['error'] = $error;
                $response['message'] = 'Failed to delete branch.';
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
            $response['message'] = 'Failed to delete branch.';
            $response['status_code'] = Response::HTTP_BAD_REQUEST;
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            Log::error($exception->getTraceAsString());

            $error = array();
            $error['message'] = 'Unknown error occurred.';

            $response['error'] = $error;
            $response['message'] = 'Failed to delete branch.';
            $response['status_code'] = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return $response;
    }
}
