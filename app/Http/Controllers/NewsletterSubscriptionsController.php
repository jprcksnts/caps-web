<?php

namespace App\Http\Controllers;

use App\Models\Newsletter\NewsletterSubscription;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class NewsletterSubscriptionsController extends Controller
{
    public function index()
    {
        $table_headers = ['email', 'mobile', 'subscribed at'];
        return view('newsletter_subscriptions.index', compact('table_headers'));
    }

    public function mail()
    {

    }

    public function retrieveList()
    {
        $newsletter_subscriptions = NewsletterSubscription::query();

        return DataTables::eloquent($newsletter_subscriptions)
            ->toJson();
    }
}
