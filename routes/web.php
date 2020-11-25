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

Route::get('/home', 'PasswordController@index')->name('home');

Auth::routes();

Route::get('/logout', 'Auth\LoginController@logout');

Route::resource('passwords', 'PasswordController');

Route::get('/reset', 'ChangePasswordController@create');

Route::post('/reset', 'ChangePasswordController@updatePassword');

Route::get('/home/decrypted', 'PasswordController@decryptedIndex');

Route::post('/login', 'UserLoginsController@store');

Route::get('/history', function (){
    $userLogins = \App\UserLogins::latest()->get();
    return view('login_history')->with('userLogins', $userLogins);
});
