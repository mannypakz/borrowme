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
Route::get('/error', function () {
    return view('error');
});

Auth::routes(['register' => true]);
Auth::routes(['verify' => true]);

// Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');
Route::post('/products/publish_products', 'ProductController@publish_products');
Route::get('/products/get_products', 'ProductController@get_products')->middleware('verified');
Route::get('/products/listing', 'ProductController@listing')->name('product_listing')->middleware('verified');
Route::post('/products/listing_save', 'ProductController@listing_save')->name('listing_save');
Route::get('/item/edit/{id}', 'ProductController@listing_edit')->middleware('verified');
Route::post('/item/update','ProductController@listing_update')->name('listing_update');
Route::get('/products/search', 'ProductController@search')->name('search');
Route::post('/products/ajax_upload', 'ProductController@ajax_upload');
Route::post('/products/delete/image', 'ProductController@ajax_delete');
// Route::resource('/products', 'ProductController');

// ORDERS ROUTES
Route::group([ 'prefix' => 'orders' ], function () {
    Route::get('', 'OrderController@index')->name('orders')->middleware('verified');
	Route::get('history', 'OrderController@history')->name('order_history')->middleware('verified');
	Route::get('{id}', 'OrderController@create')->middleware('verified');
    Route::get('{id}/review', 'OrderController@review');
    Route::post('rate', 'OrderController@rate')->name('rate_order');
	Route::post('checkout', 'OrderController@checkout')->name('checkout');
	Route::post('/save', 'OrderController@save_item')->name('save_item');
});

Route::get('/item', 'ItemController@index')->name('item_index')->middleware('verified');
Route::post('/item/delete_product', 'ItemController@delete_product')->name('delete_product');
Route::get('/item/history', 'ItemController@history')->name('item_history')->middleware('verified');
Route::post('/item/store_review', 'ItemController@store_review')->name('store_review');
Route::post('/item/ajax_get_reviews', 'ItemController@ajax_get_reviews')->name('ajax_get_reviews');
Route::get('/review/user/{id}', 'ItemController@user_review');

Route::get('/profile', 'ProfileController@index')->name('profile_index')->middleware('verified');
Route::get('/profile/favorite', 'ProfileController@favorite')->name('profile_favorite')->middleware('verified');
Route::post('/profile/update', 'ProfileController@update')->name('update_profile');
Route::post('/profile/upload', 'ProfileController@ajax_upload');

Route::get('/setting', 'SettingController@index')->name('setting_index')->middleware('verified');
Route::get('/setting/notification', 'SettingController@notification')->name('setting_notification')->middleware('verified');
Route::post('/setting/update', 'SettingController@update_password')->name('update_password')->middleware('verified');
Route::post('/setting/save', 'SettingController@save_notification')->name('save_notification');

Route::get('/login/facebook', 'Auth\LoginController@facebookRedictToProvider')->name('facebook_login');
Route::get('/login/facebook/callback', 'Auth\LoginController@facebookProviderCallback');

Route::get('/login/google', 'Auth\LoginController@googleRedictToProvider')->name('google_login');
Route::get('/login/google/callback', 'Auth\LoginController@googleProviderCallback');

Route::get('/user/verify/{token}', 'PublicController@verify_code')->name('verify_code');
Route::post('/verify/process', 'PublicController@process')->name('verify_process');
Route::post('/verify/resend', 'PublicController@resend')->name('resend_code');
Route::post('/register/upload', 'PublicController@ajax_upload')->name('company_logo_upload');
Route::get('/', 'PublicController@welcome');
Route::get('/category/{name}', 'PublicController@category_route');
Route::get('/products/single/{id}', 'PublicController@single');
Route::get('/pages/{name}', 'PublicController@footer_page');
Route::get('testmail', 'PublicController@send_contact_us_mail');
Route::post('/contact/send', 'PublicController@send_contact_us_mail')->name('send_contact_msg');
Route::get('/product/view/{id}', 'PublicController@product_view');
Route::post('/product/update', 'PublicController@mark_as_available')->name('mark_as_available');

Route::get('/register/company', function(){
	return view('layouts.register_company');
})->name('reg_comp');

Route::get('/terms', function(){
	return view('terms');
});

Route::get('/policy', function(){
	return view('policy');
});

Route::post('/register/company/process', 'PublicController@register_company')->name('register_company');
Route::get('/s/login/{pid}', 'PublicController@shopify_login');
Route::post('/s/login/process', 'PublicController@shopify_login_process')->name('s_login_process');
Route::get('/rate', 'ProfileController@rate');
Route::post('/rate/process', 'ProfileController@rate_store')->name('rate_store');

Route::get('/chat', 'ChatsController@index');
Route::post('/chat/add', 'ChatsController@add_user_group')->name('add_user_group');
Route::post('/chat/accept', 'ChatsController@accept_invite')->name('accept_invite');
Route::get('/chat/message/add/{id}', 'ChatsController@message_lender')->name('message_lender');

Route::get('admin', 'AdminController@index');
Route::get('admin/users', 'AdminController@users');
Route::post('admin/user/delete', 'AdminController@user_delete')->name('user_delete');
Route::get('admin/categories', 'AdminController@categories');
Route::post('/admin/categories/create', 'AdminController@create_category');
Route::post('/admin/menu/create', 'AdminController@create_menu')->name('create_menu');
Route::post('/admin/category/delete', 'AdminController@delete_category')->name('delete_category');

Route::group([ 'prefix' => 'search' ], function () {
    Route::get('', 'SearchController@index');
});

Route::group([ 'prefix' => 'notifications' ], function () {
    Route::get('', 'NotificationController@index');
});
