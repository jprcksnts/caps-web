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

    Route::resource('products', 'ProductsController')->except(['update', 'destroy']);
    Route::get('retrieve_list/products', 'ProductsController@retrieveList');

    Route::resource('product_types', 'ProductTypesController')->except(['update', 'destroy']);
    Route::post('product_types/{product_type}/update', 'ProductTypesController@update')->name('product_types.update');
    Route::get('retrieve_list/product_types', 'ProductTypesController@retrieveList');

    Route::resource('branches', 'BranchesController')->except(['update', 'destroy']);
    Route::get('retrieve_list/branches', 'BranchesController@retrieveList');

    Route::resource('newsletter_subscriptions', 'NewsletterSubscriptionsController')->except(['update', 'destroy']);
    Route::get('retrieve_list/newsletter_subscriptions', 'NewsletterSubscriptionsController@retrieveList');

    Route::get('reports', 'ReportsController@index')->name('reports');

});
