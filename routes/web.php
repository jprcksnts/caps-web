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

Route::get('/', 'LandingPageController@index')->name('welcome');
Route::post('/subscribe', 'LandingPageController@subscribe')->name('subscribe');

Auth::routes(['register' => false]);

Route::group(['middleware' => 'admin'], function () {

    Route::get('dashboard', 'DashboardController')->name('dashboard');

    Route::post('import', 'ImportDataController@import')->name('import');

    Route::get('inventories', 'InventoriesController@index')->name('inventories.index');
    Route::get('retrieve_list/inventories', 'InventoriesController@retrieveList');

    Route::resource('product_sales', 'ProductSalesController')->except(['update', 'destroy']);
    Route::post('product_sales/{product_sale}/update', 'ProductSalesController@update')->name('product_sales.update');
    Route::post('product_sales/{product_sale}/delete', 'ProductSalesController@delete')->name('product_sales.delete');
    Route::get('retrieve_list/product_sales', 'ProductSalesController@retrieveList');

    Route::resource('product_orders', 'ProductOrdersController')->except(['update', 'destroy']);
    Route::post('product_orders/{product_order}/update', 'ProductOrdersController@update')->name('product_orders.update');
    Route::post('product_orders/{product_order}/delete', 'ProductOrdersController@delete')->name('product_orders.delete');
    Route::get('retrieve_list/product_orders', 'ProductOrdersController@retrieveList');

    Route::resource('products', 'ProductsController')->except(['update', 'destroy']);
    Route::post('products/{product}/update', 'ProductsController@update')->name('products.update');
    Route::post('products/{product}/delete', 'ProductsController@delete')->name('products.delete');
    Route::get('retrieve_list/products', 'ProductsController@retrieveList');
    Route::get('retrieve_list/product_reorder_points', 'ProductsController@retrieveReorderPoints');

    Route::resource('product_types', 'ProductTypesController')->except(['update', 'destroy']);
    Route::post('product_types/{product_type}/update', 'ProductTypesController@update')->name('product_types.update');
    Route::post('product_types/{product_type}/delete', 'ProductTypesController@delete')->name('product_types.delete');
    Route::get('retrieve_list/product_types', 'ProductTypesController@retrieveList');

    Route::resource('branches', 'BranchesController')->except(['update', 'destroy']);
    Route::post('branches/{branch}/update', 'BranchesController@update')->name('branches.update');
    Route::post('branches/{branch}/delete', 'BranchesController@delete')->name('branches.delete');
    Route::get('retrieve_list/branches', 'BranchesController@retrieveList');

    Route::resource('newsletter_subscriptions', 'NewsletterSubscriptionsController')->except(['update', 'destroy']);
    Route::get('retrieve_list/newsletter_subscriptions', 'NewsletterSubscriptionsController@retrieveList');

    Route::get('mail/compose', 'NewsletterSubscriptionsController@compose')->name('newsletter_subscriptions.compose');
    Route::post('mail/newsletter_subscriptions', 'NewsletterSubscriptionsController@mail')->name('newsletter_subscriptions.mail');

    Route::get('reports', 'ReportsController@index')->name('reports.index');
    Route::post('reports/generate', 'ReportsController@generate')->name('reports.generate');

});
