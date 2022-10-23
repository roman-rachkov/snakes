<?php

namespace App\Jobs;

use App\Enums\BattleActions;
use App\Events\BattleUpdated;
use App\Models\Action;
use App\Models\Room;
use App\Models\Snake;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

class DoTurn implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $rooms = Room::inFight()->get();
        $rooms->each(function (Room $room, $index) {
            if (Carbon::now() >= $room->next_turn && !is_null($room->current_turn)) {
                //Обновляем всем хп в начале раунда
                $room->users->each(function (User $user) {
                    if ($user->snake->current_hp < $user->snake->max_life && $user->snake->current_hp > 0) {
                        $user->snake->current_hp++;
                    }
                    if ($user->snake->current_mp < $user->snake->max_mana && $user->snake->current_mp > 0) {
                        $user->snake->current_mp++;
                    }
                    $user->save();
                });
                $room->refresh();

                $room->current_turn->actions->each(function (Action $action) use ($room) {
                    if ($action->action === BattleActions::DEFEND) {
                        return;
                    }
                    if ($action->action === BattleActions::NONE) {
                        $room->current_turn->logs()->create([
                            'log' => 'User ' . $action->caster->user->name . ' just sleeping.',
                        ]);
                        return;
                    }
                    if ($action->action === BattleActions::ATTACK) {

                        $room->current_turn->logs()->create([
                            'log' => 'User ' . $action->caster->user->name . ' attack user ' . $action->target->user->name . '.',
                        ]);

                        $targetDodge = floor(getSumRolledDices() + $action->target->dodge);
                        $casterAccuracy = floor(getSumRolledDices() + $action->caster->accuracy);

                        if ($targetDodge > $casterAccuracy) {
                            $room->current_turn->logs()->create([
                                'log' => 'User ' . $action->caster->user->name . ' accuracy is ' . $casterAccuracy
                                    . '. User ' . $action->target->user->name . ' dodge is ' . $targetDodge
                                    . '. User ' . $action->caster->user->name . ' missed.',
                            ]);
                            return;
                        }

                        $room->current_turn->logs()->create([
                            'log' => 'User ' . $action->caster->user->name . ' attack ' . $action->direction . '.'
                        ]);

                        $targetDefends = $room->current_turn->actions->where('caster_id', $action->target->id)
                            ->where('action', BattleActions::DEFEND)->get();

                        $targetDefends->each(function ($defence) use ($room) {
                            $room->current_turn->logs()->create([
                                'log' => 'User ' . $defence->caster->user->name . ' defend ' . $defence->direction . '.'
                            ]);
                        });

                        $casterAttack = floor(getSumRolledDices('1d20') + $action->caster->attack);

                        $targetDefend = 0;

                        if (is_null($targetDefends->where('direction', $action->direction)->first())) {
                            $targetDefend = floor(getSumRolledDices('1d20') + $action->target->defence);
                        }

                        $damage = max(1, $casterAttack - $targetDefend);

                        $action->target->current_hp -= $damage;
                        $action->damage = $damage;
                        $action->save();

                        $room->current_turn->logs()->create([
                            'log' => 'User ' . $action->caster->user->name . ' attack is ' . $casterAttack . '.'
                                . 'User ' . $action->target->user->name . ' defence is ' . $targetDefend . '.'
                                . 'User ' . $action->caster->user->name . ' deal ' . $damage . ' damage.',
                        ]);

                    }
                });
                $room->current_turn->ended = true;
                $room->current_turn->save();
                $room->next_turn = Carbon::now()->addMinute();
                $room->save();
                broadcast(new BattleUpdated($room));
            }
        });
    }
}
