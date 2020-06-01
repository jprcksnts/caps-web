<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NewsletterSubscriptionsController extends Controller
{
    public function index()
    {
        return view('newsletter_subscriptions.index');
    }
}
