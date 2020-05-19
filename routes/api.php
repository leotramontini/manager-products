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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
    $api->post('login', 'Manager\Controllers\AuthController@login');
    $api->post('logout', 'Manager\Controllers\AuthController@logout');

    $api->group(['middleware' => 'auth.jwt'], function ($api) {
        $api->get('product', 'Manager\Controllers\ProductController@index');
        $api->post('product', 'Manager\Controllers\ProductController@store');
        $api->delete('product/{productId}', 'Manager\Controllers\ProductController@delete')
            ->where('productId', '[0-9]+');
        $api->put('product/{productId}', 'Manager\Controllers\ProductController@update')
            ->where('productId', '[0-9]+');
    });
});
