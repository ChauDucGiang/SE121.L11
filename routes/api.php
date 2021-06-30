<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(['namespace' => 'Api\V1\Admin'], function () {
    /*Auth*/
    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', 'AuthController@login');
        Route::get('refresh', 'AuthController@refresh');
        Route::post('register', 'AuthController@register');

        Route::group(['middleware' => 'auth:api'], function () {
            Route::get('user', 'AuthController@me');
            Route::post('logout', 'AuthController@logout');
        });
    });

    /*Have Auth*/
//    Route::group(['middleware' => 'auth:api'], function () {
    /*Admin*/
    Route::group(['prefix' => 'admin'], function () {
        Route::resource('user', 'UserController')->except(['create', 'show']);
        Route::resource('category', 'CategoryController')->except(['create']);
        Route::resource('product', 'ProductController')->except(['show']);
        Route::resource('customer', 'CustomerController')->except(['show']);
        Route::resource('order', 'OrderController')->except(['show']);
        Route::resource('package', 'PackageController')->except(['show']);
    });

    /*User*/
    Route::get('home', 'HomeController@index');
    Route::get('products', 'HomeController@getProducts');
    Route::get('categories', 'HomeController@getCategories');
    Route::get('customers', 'HomeController@getCustomers');
    Route::post('order', 'OrderController@store');
    Route::get('product/{id}', 'HomeController@getProductDetail');
    Route::get('category/{id}', 'HomeController@getListProduct');
    Route::get('download-pdf', 'HomeController@downloadPDF');
    Route::get('export-excel', 'HomeController@exportExcel');
    Route::post('reset-password', 'HomeController@resetPassword');
//    });

});

