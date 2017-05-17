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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

#auth
Route::post('auth/login', ['uses' => 'UserController@login']);

#protected routes
Route::group(['middleware' => ['extendedjwt:admin,create-users','throttle:30:5','cors']], function () {
	Route::post('users/create', ['uses' => 'UserController@create', 'as' => 'create.users']);
	Route::get('users/getByPage/{page}/{limit}', ['uses' => 'UserController@getByPage', 'as' => 'get.users']);
	Route::get('users/filter/', ['uses' => 'UserController@getByFilter', 'as' => 'filter.users']);
});
