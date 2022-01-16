<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ChatsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function createRoom(Request $request) {
        $room = new Room();
        $room->save();

        $rooms = [];
        $user = User::find(auth()->user()->id);
        if(!$user->rooms){
            array_push($rooms,$room);
            $user->rooms = json_encode($rooms);
        }else {
            $rooms = json_decode($user->rooms);
            array_push($rooms,$room);
            $user->rooms = json_encode($rooms);
        }
        $user->save();

        $toRooms = [];
        $to_user = User::find($request->id);
        if(!$to_user->rooms){
            array_push($toRooms,$room);
            $to_user->rooms = json_encode($toRooms);
        }else {
            $toRooms = json_decode($to_user->rooms);
            array_push($toRooms,$room);
            $to_user->rooms = json_encode($toRooms);
        }
        $to_user->save();

        return $room;

    }

    public function fetchMessages() {
        return Message::with('user')->latest()->paginate(20);
    }

    public function sendMessage(Request $request) {
        $message = auth()->user()->messages()->create([
            'message' => $request->message
        ]);

        broadcast(new MessageSent($message->load('user')))->toOthers();

        return $message;
    }



}
