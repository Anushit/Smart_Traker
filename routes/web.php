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

Route::get('/', function () {
    return redirect(route('login'));
});
Route::get('/', 'App\Http\Controllers\Auth\LoginController@login')->name('login');

Route::get('login', 'App\Http\Controllers\Auth\LoginController@login')->name('login');
Route::post('login', 'App\Http\Controllers\Auth\LoginController@authenticate');
Route::post('logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('logout');
Route::get('logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('logout');


Route::get('forget-password', 'App\Http\Controllers\Auth\ForgotPasswordController@showForgetPasswordForm')->name('forget.password.get');
Route::post('forget-password', 'App\Http\Controllers\Auth\ForgotPasswordController@submitForgetPasswordForm')->name('forget.password.post');
Route::get('reset-password/{token}', 'App\Http\Controllers\Auth\ForgotPasswordController@showResetPasswordForm')->name('reset.password.get');
Route::post('reset-password', 'App\Http\Controllers\Auth\ForgotPasswordController@submitResetPasswordForm')->name('reset.password.post');


Auth::routes([
    'register' =>false, // Registration Routes...
    'login' => false,
    'logout' => false,
]);

Route::prefix(\Config::get('constants.admin_url.admin'))->group(function () {
    Route::get('/dashboard', 'App\Http\Controllers\DashboardController@index')->name('dashboard');
    Route::get('/profile', 'App\Http\Controllers\ProfileController@profile')->name('profile');
    Route::post('/profile-update', 'App\Http\Controllers\ProfileController@profileUpdate')->name('profile.update');
    Route::post('/profile-change-password', 'App\Http\Controllers\ProfileController@profileChangePassword')->name('profile.change.password');

});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
