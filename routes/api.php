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

Route::get('/user', function (Request $request) {
    return $request->json(['data' => 'User logged out.'], 200);
});


Route::get('/user/login/{email}/{password}', 'UserApiController@doLogin');
Route::get('/user/get/{id}/{auth_token}', 'UserApiController@getUserProfile');


Route::get('/publication/all/{auth_token}','PublicationApiController@getAll');
Route::get('/publication/get/{id}/{auth_token}','PublicationApiController@getById');