<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EditController;
use App\Http\Controllers\DoneController;

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
    //新規登録画面表示
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register.show');
    //新規登録
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});

Route::group(['middleware' => ['auth']], function () {
    //ホーム画面表示
    Route::get('/home', [HomeController::class, 'home'])->name('home');
    // ログアウト
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    // ゴール詳細画面表示
    Route::get('/home/{goalid}', [HomeController::class, 'detail'])->name('detail');

    // ゴール作成画面表示
    Route::get('/makegoal', [EditController::class, 'goal'])->name('goal.show');
    // ゴール追加
    Route::post('/makegoal', [EditController::class, 'makeGoal'])->name('goal.make');
    // サブゴール作成画面表示
    Route::get('/makesubgoal/{goalid}', [EditController::class, 'subgoal'])->name('subgoal.show');
    // サブゴール追加
    Route::post('/makesubgoal', [EditController::class, 'makeSubgoal'])->name('subgoal.make');

    // ゴール削除
    Route::post('/deletegoal', [EditController::class, 'deleteGoal'])->name('goal.delete');
    // サブゴール削除機能
    Route::post('/deletesubgoal', [EditController::class, 'deleteSubgoal'])->name('subgoal.delete');

    // サブゴール編集画面表示
    Route::post('/editsubgoal', [EditController::class, 'editSubgoal'])->name('subgoal.edit');
    // サブゴール編集アップロード機能
    Route::post('/editsubgoal/submit', [EditController::class, 'editSubgoalSubmit'])->name('subgoal.edit.submit');
    // ゴール編集画面
    Route::post('editgoal', [EditController::class, 'editGoal'])->name('goal.edit');
    //ゴール編集機能
    Route::post('/editgoal/submit', [EditController::class, 'editGoalSubmit'])->name('goal.edit.submit');

    // リスト達成記録機能
    Route::post('donelist', [DoneController::class, 'doneList'])->name('list.done');
    // ゴール達成記録機能
    Route::post('donegoal', [DoneController::class, 'doneGoal'])->name('goal.done');
});