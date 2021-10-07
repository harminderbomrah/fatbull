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
// Route::get('/', [DashboardController::class, 'index'])->middleware('App\Http\Middleware\Authenticate')->name('dashboard');

// Route::get('/login', [AuthController::class, 'index'])->name('login');
// Route::get('/logout', [AuthController::class, 'signOut'])->name('logout');
// Route::post('/login', [AuthController::class, 'login']);
// Route::get('/register', [AuthController::class, 'registration'])->name('register');
// Route::post('/register', [AuthController::class, 'createUser']);
// Route::get('/emailverify', [AuthController::class, 'emailVerify']);
Auth::routes(['verify' => true]);
// social login
Route::get('auth/facebook', [App\Http\Controllers\Auth\FacebookController::class, 'fbRedirect'])->name('facebook');
Route::get('auth/facebook/callback', [App\Http\Controllers\Auth\FacebookController::class, 'login']);
Route::get('auth/google', [App\Http\Controllers\Auth\GoogleController::class, 'fbRedirect'])->name('google');
Route::get('auth/google/callback', [App\Http\Controllers\Auth\GoogleController::class, 'login']);
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
