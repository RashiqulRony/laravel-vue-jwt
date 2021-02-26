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

Route::group(['middleware' => ['api', 'cross'], 'namespace' => 'Api',], function ($router) {
    Route::get('/', function () {
        echo 'worked!';
    });

    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
    Route::post('refresh-token', 'AuthController@refreshToken');

    Route::group(['middleware' => ['jwt.auth']], function () {
        Route::post('me', 'AuthController@me');
        Route::post('logout', 'AuthController@logout');

        Route::apiResources([
            'product' => 'ProductController',
        ]);

    });
});
