<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HomeController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::group(['middleware' => ['guest']], function () {
    // ログイン画面表示
    Route::get('/', [AuthController::class, 'showLogin'])->name('login.show');
    // ログイン機能
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});

Route::group(['middleware' => ['auth']], function () {
    //ホーム画面表示
    Route::get('/home', [HomeController::class, 'home'])->name('home');
    // ログアウト
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});