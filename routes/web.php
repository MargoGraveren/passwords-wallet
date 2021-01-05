<?php

use App\FunctionRuns;
use App\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
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

Auth::routes();

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', 'PasswordController@index')->name('home');

Route::get('/logout', 'Auth\LoginController@logout');

Route::resource('passwords', 'PasswordController');

Route::get('/reset', 'ChangePasswordController@create')->middleware(['auth', 'verified', 'password.confirm']);

Route::post('/reset', 'ChangePasswordController@updatePassword');

Route::post('/login', 'UserLoginsController@store');

Route::get('/blocked', 'BlockedIpController@index');

Route::delete('/blocked/{id}', 'BlockedIpController@destroy');

Route::get('/blocked/{id}', 'BlockedIpController@destroy');

Route::get('/modifymode', 'ModifyModeController@index')->middleware(['auth', 'verified', 'password.confirm']);

Route::get('/modifymodeon', 'ModifyModeController@switchToTheModifyMode');

Route::get('/modifymodeoff', 'ModifyModeController@switchToTheReadMode');

Route::get('/passwords/{passwords}/delete', 'PasswordController@destroy');

Route::resource('share', 'SharePasswordController')->middleware(['auth',
    'verified', 'password.confirm']);

Route::get('/decrypted', array('uses' => 'PasswordController@decryptedIndex',
    'as' => 'decrypted'))->middleware(['auth', 'verified', 'password.confirm']);

Route::get('/history', function () {
    $userLogins = \App\UserLogins::latest()->get();
    return view('login_history')->with('userLogins', $userLogins);
});

Route::get('/activity', 'ActivityController@index');

Route::get('/activity/{activity}', 'ActivityController@putCache');

Route::get('/changes', 'DataChangeController@index');

Route::get('/details/{details}', 'DataChangeController@show');

Route::get('details/update/{details}', 'DataChangeController@restoreData');
