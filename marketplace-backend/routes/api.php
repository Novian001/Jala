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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//API route for register new user
Route::post('/register', [App\Http\Controllers\API\AuthController::class, 'register']);
//API route for login user
Route::post('/login', [App\Http\Controllers\API\AuthController::class, 'login']);

//Protecting Routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/profile', function(Request $request) {
        return auth()->user();
    });

    // API route for logout user
    Route::post('/logout', [App\Http\Controllers\API\AuthController::class, 'logout']);
});

$router->group(['prefix' => 'product'], function () use ($router) {
    $router->get('/',  [
        'as' => 'product.index', 'uses' => 'ProductController@index'
    ]);

    $router->get('/show',  [
        'as' => 'product.show', 'uses' => 'ProductController@show'
    ]);

    $router->post('/',  [
        'as' => 'product.store', 'uses' => 'ProductController@store', 'middleware' => 'apimiddleware'
    ]);

    $router->delete('/',  [
        'as' => 'product.destroy', 'uses' => 'ProductController@destroy', 'middleware' => 'api:product:destroy'
    ]);

    $router->patch('/',  [
        'as' => 'product.update', 'uses' => 'ProductController@update', 'middleware' => 'api:product:update'
    ]);

    $router->get('/search',  [
        'as' => 'product.search', 'uses' => 'ProductController@search', 'middleware' => 'api:product:all'
    ]);
});