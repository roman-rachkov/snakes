<?php

use App\Models\Room;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

//Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//    return (int) $user->id === (int) $id;
//});

Broadcast::channel('chat.{id}', function (User $user, int $id) {
    return $user->id === $id;
});

Broadcast::channel('global.chat', function (User $user) {
    return Auth::user();
}, ['guards' => ['web', 'auth', 'verified']]);

Broadcast::channel('global.arena', function (User $user) {
    return Auth::user();
}, ['guards' => ['web', 'auth', 'verified']]);

Broadcast::channel('battle.{room}', function (User $user, Room $room) {
    if ($room->is(Auth::user()->rooms()->open()->first())) {
        return Auth::user();
    }
    return false;
});
