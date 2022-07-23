<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('index', 'App\Http\Controllers\IndexController@save_res')->name('index.post');
Route::get('search/latest/{figureName?}/{userId?}', 'App\Http\Controllers\IndexController@search_latest')->name('search.latest');
Route::get('attitude', 'App\Http\Controllers\IndexController@total_attitude')->name('attitude');
Route::get('figure_detail/{figureName?}', 'App\Http\Controllers\IndexController@figure_detail')->name('figure_detail');
Route::get('sentiment_delete/{id?}', 'App\Http\Controllers\SentimentController@delete')->name('sentiment.delete');
