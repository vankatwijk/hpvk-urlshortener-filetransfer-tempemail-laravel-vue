<?php
use App\Link;
use App\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
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
Route::get('/policy', 'LinksController@policy');
Route::get('/terms', 'LinksController@terms');
Route::get('/blog', 'LinksController@blog');
Route::get('/fbdatadeletion', 'LinksController@datadeletion');

Auth::routes([
    'reset' => false,
    'verify' => false,
]);

Route::get('/logout', 'Auth\LoginController@logout');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/tree', 'HomeController@indexTree')->name('tree');

Route::get('/links/create', 'LinksController@create');

Route::group(['prefix' => 'api'], function () {
    Route::post('/shorten', 'LinksController@store');

    Route::post('/upload', 'LinksController@storeupload');

    Route::post('/upload/avatar', 'UsersController@upload');

    Route::get('/showclick/{link_id}', 'LinksController@showclick');

    Route::get('/links', 'LinksController@index');

    Route::get('/treelinks', 'LinksController@indexTrees');

    Route::post('/treelink/addRemove', 'LinksController@addRemoveTree');

    Route::post('/removeLink', 'LinksController@removeLink');
});

Route::get('/{link}', 'LinksController@show');
Route::get('/tree/{link}', 'LinksController@showtree');


Route::get('/login/{social}','Auth\LoginController@socialLogin')->where('social','twitter|facebook|linkedin|google|github|bitbucket');

Route::get('/login/{social}/callback','Auth\LoginController@handleProviderCallback')->where('social','twitter|facebook|linkedin|google|github|bitbucket');