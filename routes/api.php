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
Route::group([

    
    'prefix' => 'auth',

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});

Route::group([

    
    'middleware' => 'jwt.auth',

], function ($router) {

    Route::get('users','UserController@index');
    Route::get('users/edit/{id}','UserController@edit');
    Route::post('users/add','UserController@create');

});

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
