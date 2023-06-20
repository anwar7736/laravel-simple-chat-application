<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{User, Message};
use App\Events\MessageEvent;
use Auth;
class MessageController extends Controller
{
    public function index()
    {
        $users = User::with('unread')
                     ->where('id', '<>', Auth::id())
                     ->select(['id', 'name', 'image', 'phone'])
                     ->get(); 

        return $users;
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'receiver_id' => ['required'],
            'message' => ['required'],
        ]);

        $data['sender_id'] = Auth::id();

        $msg = Message::create($data);

        event(new MessageEvent($msg->sender_id, $msg->receiver_id));

        return response()->json([
            'status' => 'success',
            'msg' => $msg,
        ], 200);

    }

    public function show($id)
    {
        $messages = Message::with(['sender', 'receiver'])
                            ->where([
                                'sender_id' => $id,
                                'receiver_id' => Auth::id()
                            ])                   
                            ->orWhere([
                                    'sender_id' => Auth::id(),
                                    'receiver_id' => $id
                                ])
                            ->get();

        Message::where(['sender_id' => $id, 'receiver_id' => Auth::id()])
                ->update(['is_read' => 1]);

        return response()->json([
            'status' => 'success',
            'messages' => $messages,
        ], 200);
            
    }

}
