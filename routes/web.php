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

Route::get('public_figures', 'App\Http\Controllers\IndexController@pf')->name('pf');
Route::get('/', 'App\Http\Controllers\IndexController@index')->name('index');
Route::get('sentiment', 'App\Http\Controllers\SentimentController@index')->name('sentiment');
Route::get('sentiment_detail/{id?}', 'App\Http\Controllers\SentimentController@detail')->name('sentiment.detail');
Route::get('profile', 'App\Http\Controllers\ProfileController@home')->name('profile.home');
Route::get('profile/update', 'App\Http\Controllers\ProfileController@index')->name('profile');
Route::post('profile/update', 'App\Http\Controllers\ProfileController@update')->name('profile.post');
Route::get('login', 'App\Http\Controllers\IndexController@index')->name('login');
Route::post('login', 'App\Http\Controllers\IndexController@login')->name('login.post');
Route::get('comparison', 'App\Http\Controllers\IndexController@comparison')->name('comparison');
Route::get('logout', 'App\Http\Controllers\IndexController@logout')->name('logout');
Route::get('register', 'App\Http\Controllers\RegisterController@index')->name('register');
Route::post('register', 'App\Http\Controllers\RegisterController@store')->name('register.post');

Route::get('first_time', function() {
    \Illuminate\Support\Facades\Artisan::call('config:clear');
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    \Illuminate\Support\Facades\Artisan::call('config:cache');
    \Illuminate\Support\Facades\Artisan::call('storage:link');
    return redirect()->route('index');
});