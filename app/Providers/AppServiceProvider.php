<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (config('app.env') == 'production') {
            $this->app->bind('path.public', function () {
                return base_path('public_html');
            });
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (config('app.env') == 'production') {
            URL::forceScheme('https');
        }
    }
}
