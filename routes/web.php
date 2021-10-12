<?php

use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FacebookController;
use App\Http\Controllers\DashboardController;

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
    return redirect()->route('home');
});

Auth::routes(['verify' => true]);
// social login
Route::get('auth/facebook', [App\Http\Controllers\Auth\FacebookController::class, 'socialRedirect'])->name('facebook');
Route::get('auth/facebook/callback', [App\Http\Controllers\Auth\FacebookController::class, 'login']);
Route::get('auth/google', [App\Http\Controllers\Auth\GoogleController::class, 'socialRedirect'])->name('google');
Route::get('auth/google/callback', [App\Http\Controllers\Auth\GoogleController::class, 'login']);
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/profile', [App\Http\Controllers\HomeController::class, 'profile'])->name('profile');

Route::post('/profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile']);

Route::get('/profile/password', [App\Http\Controllers\HomeController::class, 'password']);

Route::post('/profile/{id}/password', [App\Http\Controllers\HomeController::class, 'updatePassword']);
