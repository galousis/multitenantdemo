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


Route::post('users/create', ['uses' => 'UserController@create', 'as' => 'create.users']);
Route::post('users/getByPage/{page}/{limit}', ['uses' => 'UserController@getByPage', 'as' => 'get.users']);
Route::post('users/filter/', ['uses' => 'UserController@getByFilter', 'as' => 'filter.users']);

//$app->group(
//	['prefix'=>'api/v1'],
//	function ($app) {
//		//auth
//		$app->post('auth/login', [
//			'middleware' => ['throttle:30:5','cors'],
//			'uses' => 'UserController@login',
//		]);
//		//protected routes
//		$app->group(['middleware' => ['jwt','throttle:30:5','cors']],function ($app){
//			//manager
//			require_once 'manager.php';
//		});
//	});