<?php

use App\Http\Controllers\API\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
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


Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::namespace('Auth')->group(function () {
//     Route::get('/{any}', [HomeController::class, 'index'])->where('any', '.*');
// });
// Route::get('/cek', [App\Http\Controllers\MenuAksesController::class, 'index'])->name('cek');

//Route::get('/{any}', [HomeController::class, 'index'])->where('any', '.*');
Route::get('/', function () {
    return view('welcome');
});

Route::get('/{any}', [HomeController::class, 'index'])->where('any', '.*');
