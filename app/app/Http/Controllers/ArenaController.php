<?php

namespace App\Http\Controllers;

use App\Enums\RoomMode;
use App\Enums\RoomStatus;
use App\Events\BattleStarted;
use App\Events\NewRoomCreated;
use App\Events\UserJoinBattle;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ArenaController extends Controller
{
    public function index()
    {
        $rooms = Room::wait()->get();

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

        broadcast(new NewRoomCreated($room));

        return redirect(route('arena.join', ['room' => $room]));
    }

    public function joinRoom(Request $request, Room $room)
    {
        $isUserInBattle = $room->is(Auth::user()->rooms()->open()->first());

        if (!$isUserInBattle && !$room->isFull) {
            $room->users()->attach(Auth::user());
            $room->refresh();

            broadcast(new UserJoinBattle(Auth::user(), $room));

            if ($room->isFull) {
                $room->status = RoomStatus::FIGHT;
                $room->save();
                broadcast(new BattleStarted($room));
            }
        }

        return Inertia::render('Game/BattleRoom', ['room' => $room]);
    }
}
