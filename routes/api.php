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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('articles','ArticlesController@index')->name('show.articles');
Route::get('article/{id}','ArticlesController@show')->name('show.article');
Route::post('article','ArticlesController@store')->name('store.article');
Route::put('article','ArticlesController@store')->name('update.article');
Route::delete('article/{id}','ArticlesController@destroy')->name('delete.article');
