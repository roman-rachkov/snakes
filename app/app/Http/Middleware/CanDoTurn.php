<?php

namespace App\Http\Middleware;

use App\Enums\RoomStatus;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CanDoTurn
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $room = $request->route('room');

        if ($room->status != RoomStatus::FIGHT || !$room->users->contains(Auth::user())) {
            abort(403);
        }

        return $next($request);
    }
}
