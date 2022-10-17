<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class BattleController extends Controller
{

    public function turn(Request $request, Room $room)
    {
        dd($request);
        if (is_null($room->current_turn)) {
            $room->turns()->create([
                'turn' => $room->turns->count() + 1
            ]);
            $room->refresh();
        }
    }

}
