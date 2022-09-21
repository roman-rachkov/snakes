<?php

namespace App\Listeners;

use App\Models\Snake;
use App\Models\SnakeType;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateSnakeForNewUser
{

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle(Registered $event)
    {
        Snake::makeSnake($event->user, SnakeType::first());
    }
}
