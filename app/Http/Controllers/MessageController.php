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
        if(request()->ajax())
        {
            $query = User::with('unread');
            
            if(!empty(request('query')))
            {
                $query->where('name', 'LIKE', '%'.request('query').'%')
                      ->orWhere('email', 'LIKE', '%'.request('query').'%');
            }

            $users = $query->select(['id', 'name', 'image', 'email'])->orderBy('name')->get(); 

            return view('user.users', compact('users'));
        }
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
        $messages = Message::with('sender')
                           ->where(function($query) use($id) {
                                $query->where([
                                    'sender_id' => $id,
                                    'receiver_id' => Auth::id()
                                ]);
                           })
                           ->orWhere(function($query) use($id) {
                                $query->where([
                                    'sender_id' => Auth::id(),
                                    'receiver_id' => $id,
                                ]);
                           })
                          ->get();

        Message::where(['sender_id' => $id, 'receiver_id' => Auth::id()])
                ->update(['is_read' => 1]);

       return view('message.messages', compact('messages'));
            
    }

}
