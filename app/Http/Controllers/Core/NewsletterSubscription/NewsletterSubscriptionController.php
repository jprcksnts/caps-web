<?php

namespace App\Http\Controllers\Core\NewsletterSubscription;

use App\Http\Controllers\Controller;
use App\Models\Newsletter\NewsletterSubscription;
use Illuminate\Database\QueryException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NewsletterSubscriptionController extends Controller
{
    public static function create($email, $mobile)
    {
        $response = array();

        try {
            DB::beginTransaction();

            $newsletter_subscription = new NewsletterSubscription();
            $newsletter_subscription->email = $email;
            $newsletter_subscription->mobile = $mobile;
            $newsletter_subscription->save();

            DB::commit();

            $data = array();
            $data['newsletter_subscription'] = $newsletter_subscription;

            $response['data'] = $data;
            $response['message'] = 'Newsletter subscription successfully created.';
            $response['status_code'] = Response::HTTP_OK;
        } catch (QueryException $exception) {
            Log::error($exception->getMessage());
            Log::error($exception->getTraceAsString());

            $error_code = $exception->errorInfo[1];
            Log::error($error_code);

            $error = array();
            $error['message'] = 'Query exception occurred.';

            $response['error'] = $error;
            $response['message'] = ' Failed to create newsletter subscription.';
            $response['status_code'] = Response::HTTP_BAD_REQUEST;
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            Log::error($exception->getTraceAsString());

            $error = array();
            $error['message'] = 'Unknown error occurred.';

            $response['error'] = $error;
            $response['message'] = ' Failed to create newsletter subscription.';
            $response['status_code'] = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return $response;
    }

    public static function update($newsletter_subscription_id, $email, $mobile)
    {
        $response = array();

        try {
            $newsletter_subscription = NewsletterSubscription::where('id', $newsletter_subscription_id)->first();

            if ($newsletter_subscription != null) {
                // if newsletter subscription exists
                DB::beginTransaction();

                $newsletter_subscription->email = $email;
                $newsletter_subscription->mobile = $mobile;
                $newsletter_subscription->save();

                DB::commit();

                $data = array();
                $data['newsletter_subscription'] = $newsletter_subscription;

                $response['data'] = $data;
                $response['message'] = 'Newsletter subscription successfully updated.';
            } else {
                // if newsletter subscription does not exist
                $error = array();
                $error['message'] = 'Newsletter subscription not found.';

                $response['error'] = $error;
                $response['message'] = 'Failed to update newsletter subscription.';
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
            $response['message'] = ' Failed to update newsletter subscription.';
            $response['status_code'] = Response::HTTP_BAD_REQUEST;
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            Log::error($exception->getTraceAsString());

            $error = array();
            $error['message'] = 'Unknown error occurred.';

            $response['error'] = $error;
            $response['message'] = ' Failed to update newsletter subscription.';
            $response['status_code'] = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return $response;
    }

    public static function delete($newsletter_subscription_id)
    {
        $response = array();

        try {
            $newsletter_subscription = NewsletterSubscription::where('id', $newsletter_subscription_id)->first();

            if ($newsletter_subscription != null) {
                // if newsletter subscription exists
                DB::beginTransaction();

                $newsletter_subscription->delete();

                DB::commit();

                $response['message'] = 'Newsletter subscription successfully deleted.';
                $response['status_code'] = Response::HTTP_OK;
            } else {
                // if newsletter subscription does not exist
                $error = array();
                $error['message'] = 'Newsletter subscription not found.';

                $response['error'] = $error;
                $response['message'] = 'Failed to delete newsletter subscription.';
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
            $response['message'] = ' Failed to delete newsletter subscription.';
            $response['status_code'] = Response::HTTP_BAD_REQUEST;
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            Log::error($exception->getTraceAsString());

            $error = array();
            $error['message'] = 'Unknown error occurred.';

            $response['error'] = $error;
            $response['message'] = ' Failed to delete newsletter subscription.';
            $response['status_code'] = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return $response;
    }
}
