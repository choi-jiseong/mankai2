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

    public function chatIndex() {
        $user = User::find(auth()->user()->id);
        $roomUserNames = [];
        $rooms = [];
        if($user->rooms)
        {   $rooms = json_decode($user->rooms);
            // dd($rooms);
            $roomIds = [];
            for ($i = 0; $i < count($rooms); $i++){
                array_push($roomIds, $rooms[$i]->id);
                array_push($roomUserNames, $rooms[$i]->to_user);
            }
            $rooms = Room::whereIn('id', $roomIds)->get();}
        return Inertia::render('Chat', ['user'=>auth()->user(), 'rooms' => $rooms, 'chatUsers'=>$roomUserNames]);
    }

    public function createRoom(Request $request) {
        $to_user = User::find($request->id);
        $user = User::find(auth()->user()->id);

        $room = new Room();
        $room->save();
        $room['to_user'] = $to_user->name;

        $rooms = [];
        $toRooms = [];

        if(!$user->rooms){
            array_push($rooms,$room);
            $user->rooms = json_encode($rooms);
        }else {
            $rooms = json_decode($user->rooms);
            array_push($rooms,$room);
            $user->rooms = json_encode($rooms);
        }
        $user->save();

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

    public function fetchMessages($roomId) {
        return Message::where('room_id', $roomId)->with('user')->latest()->paginate(20);
    }

    public function sendMessage(Request $request) {
        echo $request->room_id;
        $message = auth()->user()->messages()->create([
            'message' => $request->message,
            'room_id' => $request->room_id
        ]);

        broadcast(new MessageSent($message->load('user')))->toOthers();

        return $message;
    }



}
