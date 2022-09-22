<?php

namespace App\Http\Controllers;

use App\Enums\RoomMode;
use App\Enums\RoomStatus;
use App\Models\Room;
use Illuminate\Http\Request;

class ArenaController extends Controller
{
    public function index()
    {
        $arr = [];

        for ($i = 1; $i < 10; $i++) {
            $arr[] = [
                'id' => $i,
                'playerName' => 'test' . $i,
                'maxLevel' => rand(3, 8),
                'minLevel' => rand(1, 2),
                'bid' => rand(10, 1000),
                'mode' => RoomMode::arrayValues()[rand(0, count(RoomMode::arrayValues()) - 1)],
                'currentPlayers' => rand(1, 2),
                'maxPlayers' => rand(2, 8),
                'status' => RoomStatus::arrayValues()[rand(0, 1)]
            ];
        }


        return json_encode($arr);
    }
}
