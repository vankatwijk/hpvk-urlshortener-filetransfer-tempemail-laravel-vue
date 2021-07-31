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

Route::get('/', 'LinksController@create');

Auth::routes([
    'reset' => false,
    'verify' => false,
]);

Route::get('/logout', 'Auth\LoginController@logout');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/links/create', 'LinksController@create');

Route::group(['prefix' => 'api'], function () {
    Route::post('/shorten', 'LinksController@store');

    Route::get('/links', 'LinksController@index');
});

Route::get('/{link}', 'LinksController@show');

