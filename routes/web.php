<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\TeamController;
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

Route::prefix('team')->group(static function () {
   Route::get('/', [TeamController::class, 'index'])->name('team.list');
   Route::get('add', [TeamController::class, 'add'])->name('team.add');
   Route::post('create', [TeamController::class, 'create'])->name('team.create');

   Route::get('edit/{id}', [TeamController::class, 'edit'])->name('team.edit');
   Route::post('update', [TeamController::class, 'update'])->name('team.update');

   Route::delete('delete/{id}', [TeamController::class, 'delete'])->name('team.delete');

});


Route::prefix('game')->group(static function () {
    Route::get('/', [GameController::class, 'index'])->name('game.list');

    Route::get('add', [GameController::class, 'add'])->name('game.add');
    Route::post('create', [GameController::class, 'create'])->name('game.create');

    Route::delete('delete/{id}', [GameController::class, 'delete'])->name('game.delete');
});

Route::get('error', [SystemController::class, 'errorPage'])->name('error');
Route::get('home', [SystemController::class, 'home'])->name('home');
