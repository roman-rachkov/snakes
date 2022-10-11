<?php

namespace App\Http\Controllers;

use App\Enums\RoomMode;
use App\Enums\RoomStatus;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ArenaController extends Controller
{
    public function index()
    {
        $rooms = Room::open()->get();

        //TODO Write normal settings
        $rooms->map(function ($item) {

            $item['min_level'] = max(1, $item->user->snake->level - config('main.min_level', 2));
            $item['max_level'] = $item->user->snake->level + config('main.max_level', 2);
            $item['current_players'] = $item->users->count();

        });

        return $rooms;
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            'password' => '',
            'bid' => 'integer|multiple_of:10',
            'max_players' => 'integer|multiple_of:2',
            'mode' => 'in:' . implode(',', RoomMode::arrayValues()),
        ]);

        $data['user_id'] = Auth::user()?->id;

        if (str($data['password'])->length() > 0) {
            $data['status'] = RoomStatus::CLOSED;
        }

        $room = Room::create($data);

        return redirect(route('arena.join', ['room' => $room]));
    }

    public function joinRoom(Request $request, Room $room)
    {
        $isUserInBattle = $room->is(Auth::user()->rooms()->open()->first());

        if(!$isUserInBattle){
            $room->users()->attach(Auth::user());
        }

        return Inertia::render('Game/BattleRoom', ['room' => $room]);
    }
}
