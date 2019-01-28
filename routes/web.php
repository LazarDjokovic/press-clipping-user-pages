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

Route::resource('/printed','PrintedsController');
Route::resource('/digital','DigitalsController');

Route::post('/printeds/search','PrintedsController@search');
Route::post('/digitals/search','DigitalsController@search');

Route::post('/printeds/view','PrintedsController@view');