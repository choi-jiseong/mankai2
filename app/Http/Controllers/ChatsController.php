<?php

namespace App\Http\Controllers;

use App\Events\MessageDelete;
use App\Events\MessageSent;
use App\Models\Message;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Intervention\Image\Facades\Image;

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


        $rooms = [];
        $toRooms = [];
        $room['to_user'] = $to_user->name;
        if($user->rooms){
            $rooms = json_decode($user->rooms);
        }

        array_push($rooms,$room);
        $user->rooms = json_encode($rooms);
        $user->save();

        $room['to_user'] = $user->name;
        if($to_user->rooms){
            $toRooms = json_decode($to_user->rooms);
        }
        array_push($toRooms,$room);
        $to_user->rooms = json_encode($toRooms);
        $to_user->save();

        return $room;

    }

    public function fetchMessages($roomId) {
        return Message::where('room_id', $roomId)->with('user')->latest()->paginate(20);
    }

    public function sendMessage(Request $request) {

        $file_path = null;

        // dd($request->file('file'));
        if ($request->hasFile('file')) {

            $fileType = explode("/",$request->file('file')->getClientMimeType());
            if($fileType[0] == 'image') {
                $fileName = time() . '_' . $request->file('file')->getClientOriginalName();
                $request->file('file')->storeAs('/public/images/'.$request->room_id.'/', $fileName);
                $file_path ='/images/'.$request->room_id.'/'.$fileName ;
            }else {
                $fileName = $request->file('file')->getClientOriginalName();
                $request->file('file')->storeAs('/public/files/'.$request->room_id.'/', $fileName);
                $file_path ='/files/'.$request->room_id.'/'.$$fileName ;

            }

        }

        $message = auth()->user()->messages()->create([
            'message' => $request->message,
            'room_id' => $request->room_id,
            'file' => $file_path,
        ]);

        broadcast(new MessageSent($message->load('user')))->toOthers();

        return $message;
    }

    public function deleteMessage($id) {
        $message = Message::findOrFail($id);
        if($message->file) {
            $file_path = 'public/'.$message->file;
            Storage::delete($file_path);
        }

        broadcast(new MessageDelete($message->load('user')))->toOthers();
        $message->delete();
        return  'ok';
    }



}
