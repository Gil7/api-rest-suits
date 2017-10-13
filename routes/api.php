<?php

use Illuminate\Http\Request;

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




Route::post('/users/authenticate','Api\UsersController@authenticate');
Route::group(['middleware' => ['jwt.auth']], function(){
    Route::post('/newsizes','Api\SizesController@posibleSizes');
    Route::get('/sales/today','Api\SalesController@salestoday');
    Route::get('/rentals/today','Api\RentalsController@rentalstoday');
    Route::post('/users/profile','Api\UsersController@profile');
    Route::resource('/users','Api\UsersController');
    Route::get('/products/search/{name}','Api\ProductsController@productByName');
    Route::resource('/products','Api\ProductsController');
    Route::resource('/sizes', 'Api\SizesController');
    Route::resource('/sales', 'Api\SalesController');
    Route::resource('/rentals', 'Api\RentalsController');
});
Route::resource('/statistics','Api\StatisticsController');


