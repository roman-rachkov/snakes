<?php

namespace App\Http\Controllers;

use App\Dto\Message;
use App\Events\ChatMessageRecived;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {
        $message = Message::create(
            [
                'author' => Auth::user(),
                'message' => $request->message,
                'recipient' => $request->recipient ? User::firstWhere('name', $request->recipient) : null,
                'time' => Carbon::now()
            ]
        );

        broadcast(new ChatMessageRecived($message))->toOthers();
        return ['status' => 'ok'];
    }

    public function userJoin(Request $request)
    {
        broadcast(new ChatMessageRecived(Message::create([
            'author' => Auth::user(),
            'message' => __('User '. Auth::user()->name .' joint to game.'),
            'recipient' => null,
            'time' => Carbon::now()
        ])))->toOthers();
        return ['status' => 'join'];
    }
}
