<?php

use App\Enums\RoomMode;
use App\Http\Controllers\ArenaController;
use App\Http\Controllers\BattleController;
use App\Http\Controllers\ChatController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('language/{language}', function (string $language) {
    \Illuminate\Support\Facades\Session::put('locale', $language);
    return redirect()->back();
})->name('language');

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('main');

Route::get('/game', function () {
    return Inertia::render('Game/Arena', ['gameModes' => RoomMode::arrayValues()]);
})->middleware(['auth', 'verified', 'notInBattle'])->name('arena');

Route::get('/profile', function () {
    return '123';
})->middleware(['auth', 'notInBattle'])->name('profile');

Route::post('chat', [ChatController::class, 'sendMessage'])->middleware(['auth', 'verified'])->name('chat');

Route::get('/arena', [ArenaController::class, 'index'])->middleware(['auth', 'verified', 'notInBattle'])->name('arena.rooms');
Route::post('/arena', [ArenaController::class, 'create'])->middleware(['auth', 'verified', 'notInBattle'])->name('arena.create');
Route::get('/arena/battle/{room}', [ArenaController::class, 'joinRoom'])->middleware(['auth', 'verified', 'canJoinToRoom'])->name('arena.join');
Route::post('/arena/battle/{room}', [BattleController::class, 'turn'])->middleware(['auth', 'verified', 'canDoTurn'])->name('battle.turn');


require __DIR__ . '/auth.php';
