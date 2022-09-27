<?php

namespace App\Http\Controllers\Frontend\Chat;

use App\Events\MessageSentEvent;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    function Chatview()
    {
        return view('Frontend.Chat.master-2');
    }
    function ChatSearchUser(Request $request)
    {
        $search = $request->search;
        $users =   User::where('name', 'LIKE', "%$search%")->where('id', '!=', auth()->id())->get();
        $view = view('Frontend.Chat.ajax.search-user', compact('users'))->render();

        return response()->json([
            'view' => $view,
        ]);
    }
    function FetchUser(Request $request)
    {
        $id = $request->id;
        $user =  User::findorfail($id);
        $messages = Message::where([
            'from_id' => auth()->id(),
            'to_id' => $user->id
        ])
            ->orwhere([
                'to_id' => auth()->id(),
                'from_id' => $user->id
            ])
            ->get();

        $view = view('Frontend.Chat.ajax.message', compact('user', 'messages'))->render();


        return response()->json([
            'view' => $view,
        ]);
    }
    function SendMessage(Request $request)
    {


        // return $request;
        $user =  User::findorfail($request->to_id);

        $message = new Message;
        $message->from_id = auth()->id();
        $message->to_id = $request->to_id;
        $message->body = $request->body;
        $message->save();

        broadcast(new MessageSentEvent($message, $user))->toOthers();

        // return response()->json([
        //     'view' => $view,
        // ]);
    }
}
