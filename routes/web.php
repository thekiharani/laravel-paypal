<?php

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

Route::get('/', 'ProductController@purchase')->name('welcome');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::namespace('Paypal')->prefix('payment')->group(function() {
	Route::post('create', 'PaymentController@create')->name('payment.create');
	Route::get('{order}/execute', 'PaymentController@execute')->name('payment.execute');
	Route::get('cancel', 'PaymentController@cancel')->name('payment.cancel');
});

Route::resource('products', 'ProductController');
Route::resource('orders', 'OrderController');
// Route::get('purchase', 'ProductController@purchase')->name('purchase');

