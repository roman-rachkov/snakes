<?php

namespace App\Http\Controllers;

use App\Dto\Message;
use App\Events\ChatMessageReceived;
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

        broadcast(new ChatMessageReceived($message))->toOthers();
    }

}
