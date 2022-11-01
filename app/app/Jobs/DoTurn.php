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
            if (Carbon::now() >= $room->next_turn) {
                if (is_null($room->current_turn)) {
                    $room->turns()->create([
                        'turn' => $room->turns->count() + 1
                    ]);
                }
                //Обновляем всем хп в начале раунда
                $room->snakes->each(function (Snake $snake) use ($room) {
                    if ($snake->current_hp < $snake->max_life && $snake->current_hp > 0) {
                        $snake->current_hp++;
                    }
                    if ($snake->current_mp < $snake->max_mana && $snake->current_mp > 0) {
                        $snake->current_mp++;
                    }
                    $snake->save();
                });
                $room->current_turn->logs()->create([
                    'log' => 'All life snakes restore 1 HP.',
                ]);
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
                            ->where('action', BattleActions::DEFEND);

                        $targetDefends->each(function ($defence) use ($room) {
                            $room->current_turn->logs()->create([
                                'log' => 'User ' . $defence->caster->user->name . ' defend ' . $defence->direction . '.'
                            ]);
                        });

                        $casterAttack = floor(getSumRolledDices('1d20') + $action->caster->attack);

                        $targetDefend = 0;

                        if (!is_null($targetDefends->where('direction', $action->direction)->first())) {
                            $targetDefend = floor(getSumRolledDices('1d20') + $action->target->defence);
                        }

                        $damage = max(1, $casterAttack - $targetDefend);

                        $action->target->current_hp -= $damage;
                        $action->target->save();
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
                broadcast(new BattleUpdated($room->withoutRelations()));
            }
        });
    }
}
