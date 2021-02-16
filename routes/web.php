<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'HomeController@index')->name('home');

Route::get('/search/{query}', 'SearchController@index')->name('search.index');
Route::get('/favorites', 'SearchController@favorites')->name('search.favorites');
Route::post('/search', 'SearchController@store')->name('search.store');
Route::post('/like', 'SearchController@update')->name('search.update');
