<?php

namespace App\Http\Controllers;

use App\Enums\BattleActions;
use App\Models\Action;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BattleController extends Controller
{

    public function turn(Request $request, Room $room)
    {
        $actions = collect($request->input('actions'));
        if (is_null($room->current_turn)) {
            $room->turns()->create([
                'turn' => $room->turns->count() + 1
            ]);
            $room->refresh();
        }

        if ($actions->isEmpty()) {
            $room->current_turn->actions()->create([
                'caster_id' => Auth::user()->snake->id,
                'target_id' => Auth::user()->snake->id,
                'action' => BattleActions::NONE,
            ]);
            return;
        }

        //TODO rewrite to normal settings
        $points = 2;

        $actions->each(function ($item) use ($points, $room) {
            $action = $item['action'];
            dump($this->getActionCost($action));
            if ($this->getActionCost($action) <= $points) {
                $points -= $this->getActionCost($action);

                $data = [
                    'caster_id' => $item['caster'],
                    'target_id' => $item['target'],
                    'action' => $action,
                    'direction' => $item['direction']
                ];

                $room->current_turn->actions()->create($data);
            }
        });
    }

    private function getActionCost(string $action)
    {
        switch ($action) {
            case BattleActions::DEFEND:
            case BattleActions::ATTACK:
                return 1;
            case BattleActions::CAST:
                return 2;
            default:
                return 0;
        }
    }

}
