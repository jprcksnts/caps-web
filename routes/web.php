<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register' => false]);

Route::group(['middleware' => 'admin'], function () {

    Route::get('dashboard', 'DashboardController')->name('dashboard');

    Route::get('products', 'ProductsController@index')->name('products');

    Route::get('product_types', 'ProductTypesController@index')->name('product_types');

    Route::get('branches', 'BranchesController@index')->name('branches');

    Route::get('newsletter_subscriptions', 'NewsletterSubscriptionsController@index')->name('newsletter_subscriptions');

});
