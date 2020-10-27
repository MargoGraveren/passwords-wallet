<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', 'PasswordController@index');

Auth::routes();

Route::get('/logout', 'Auth\LoginController@logout');

Route::resource('passwords', 'PasswordController');
//
//Route::post('/reset', 'Auth\ResetPasswordController@update')->name('password.update');

Route::get('main-password/reset', 'ChangePasswordController@create');

Route::post('main-password/reset', 'ChangePasswordController@updatePassword');

