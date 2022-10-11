<?php

use App\Enums\RoomMode;
use App\Http\Controllers\ArenaController;
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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('main');

Route::get('/game', function () {
    return Inertia::render('Game/Arena', ['gameModes' => RoomMode::arrayValues()]);
})->middleware(['auth', 'verified', 'notInBattle'])->name('game.arena');

Route::get('/profile', function () {
    return '123';
})->middleware(['auth', 'notInBattle'])->name('profile');

Route::post('chat', [ChatController::class, 'sendMessage'])->middleware(['auth', 'verified', 'notInBattle'])->name('chat');

Route::get('/arena', [ArenaController::class, 'index'])->middleware(['auth', 'verified', 'notInBattle'])->name('arena');
Route::post('/arena', [ArenaController::class, 'create'])->middleware(['auth', 'verified', 'notInBattle'])->name('arena.create');
Route::get('/arena/battle/{room}', [ArenaController::class, 'joinRoom'])->middleware(['auth', 'verified', 'notInBattle'])->name('arena.join');

require __DIR__ . '/auth.php';
