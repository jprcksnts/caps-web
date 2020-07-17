<?php

namespace App\Http\Controllers;

use App\Mail\NewsletterMail;
use App\Models\Newsletter\NewsletterSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;

class NewsletterSubscriptionsController extends Controller
{
    public function index()
    {
        $table_headers = ['email', 'mobile', 'subscribed at'];
        return view('newsletter_subscriptions.index', compact('table_headers'));
    }

    public function compose()
    {
        $form_action = [
            'page_title' => 'Compose Newsletter',
            'route' => route('newsletter_subscriptions.mail')
        ];
        return view('newsletter_subscriptions.compose', compact('form_action'));
    }

    public function mail(Request $request)
    {
        $subscriber_mails = NewsletterSubscription::all()->pluck('email');
        foreach ($subscriber_mails as $recipient) {
            $data = [
                'subject' => $request->subject,
                'content' => $request->message,
            ];

            Mail::to($recipient)->send(new NewsletterMail($data));
        }

        return redirect(route('newsletter_subscriptions.index'))
            ->with('success', 'Newsletter sent successfully!');
    }

    public function retrieveList()
    {
        $newsletter_subscriptions = NewsletterSubscription::query();

        return DataTables::eloquent($newsletter_subscriptions)
            ->toJson();
    }
}
