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
Route::post('auth/signup', ['uses' => 'UserController@signup']);

#protected routes
Route::group(['middleware' => ['extendedjwt:admin,create-users','throttle:30:5','cors']], function () {

	//users
	Route::post('auth/me', ['as' => 'api.me.show', 'uses' => 'UserController@me']);
//	Route::patch('auth/me', ['as' => 'api.me.update', 'uses' => 'UserController@update']);
//	Route::put('auth/me', ['as' => 'api.me.update', 'uses' => 'UserController@update']);
	Route::post('users', ['uses' => 'UserController@create', 'as' => 'api.create.user']);
	Route::resource('users', 'UserController', array('only' => array('index')));
//	Route::get('users/filter/', ['uses' => 'UserController@getByFilter', 'as' => 'filter.users']);

	//Destinations
//	Route::get('destinations', ['as' => 'api.destinations.show', 'uses' => 'DestinationController@findAll']);
//	Route::post('destinations', ['as' => 'api.destinations.create', 'uses' => 'DestinationController@create']);
//	Route::resource('destinations', 'DestinationController', array('only' => array('index')));

	//Tours
//	Route::get('tours', ['as' => 'api.tours.show', 'uses' => 'TourController@findAll']);
//	Route::post('tours', ['as' => 'api.tours.create', 'uses' => 'TourController@create']);
//	Route::resource('tours', 'TourController', array('only' => array('index')));

	//tours destinations
//	Route::patch('tours/{tours}/destinations', ['as' => 'api.tours.destinations.sync', 'uses' => 'ToursDestinationsController@sync']);
//	Route::resource('tours.destinations', 'ToursDestinationsController', ['only' => ['index', 'store', 'destroy']]);


});
