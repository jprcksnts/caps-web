<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LandingPageController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function subscribe(Request $request)
    {
        $input = $request->all();
        $response = Core\NewsletterSubscription\NewsletterSubscriptionController::create($input['email'], $input['mobile']);

        if ($response['status_code'] == Response::HTTP_OK) {
            $status = 'success';
            $message = 'Thank you for subscribing to our newsletter.';
        } else {
            $status = 'error';
            $message = $response['message'];
        }

        return redirect(route('welcome'))->with($status, $message);
    }
}
