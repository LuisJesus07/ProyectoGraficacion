<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


//rutas para el mapa
Route::get('/mapa','PlaceController@index');

//rutas places
Route::get('/get_places/{city_id}', 'PlaceController@getPlacesByCity');
Route::get('/get_place_by_id/{id}', 'PlaceController@getPlaceById');


//rutas admin
Route::group(['middleware' => ['role:Administrador']], function () {

	Route::get('/cities', 'AdminController@index');
	Route::get('/cities/{id}', 'AdminController@city_detail');
	Route::post('/store_place', 'AdminController@store_place');
	Route::get('/places/{id}', 'AdminController@place_detail');
	Route::put('/update_place', 'AdminController@update_place');
	Route::get('/delete_place/{id}', 'AdminController@delete_place');
});
