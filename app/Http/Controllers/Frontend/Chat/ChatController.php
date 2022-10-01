<?php

namespace App\Http\Controllers\Frontend\Chat;

use App\Events\MessageSentEvent;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    function Chatview()
    {

        $authId = Auth::id();

        $contactIds = Message::where('from_id', $authId)
            ->orWhere('to_id', $authId)->select(["from_id", "to_id"])
            ->latest('id')
            ->groupBy("from_id", "to_id")
            ->get()
            ->map(function ($user) use ($authId) {
                return ($user->from_id != $authId) ? $user->from_id : $user->to_id;
            })
            ->unique();

        $users = User::whereIntegerInRaw("id", $contactIds)
            ->latest('id')
            ->get(["id", "name", 'email', 'last_seen']);

        return view('Frontend.Chat.master-2', compact('users'));
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
        //   $messages = Message::where([
        //     'from_id' => auth()->id(),
        //     'to_id' => $user->id
        // ])
        //     ->orwhere([
        //         'to_id' => auth()->id(),
        //         'from_id' => $user->id,
        //     ])
        //     ->get();

        $messages =  Message::where(function ($q) {
            $q->where('from_id',  auth()->id())
                ->orWhere('to_id',  auth()->id());
        })->where(function ($q) use ($user) {
            $q->where('to_id', $user->id)
                ->orWhere('from_id', $user->id);
        })->get();


        $view = view('Frontend.Chat.ajax.message', compact('user', 'messages'))->render();


        return response()->json([
            'view' => $view,
        ]);
    }
    function SendMessage(Request $request)
    {

        $request->validate([
            'body' => ['required']
        ]);
        
        $user =  User::findorfail($request->to_id);

        $message = new Message;
        $message->from_id = auth()->id();
        $message->to_id = $request->to_id;
        $message->body = $request->body;
        $message->save();

        // broadcast(new MessageSentEvent($user, $message))->toOthers();
        broadcast(new MessageSentEvent($user, $message))->toOthers();

        // return response()->json([
        //     'view' => $view,
        // ]);
    }
    function FetchUserList(Request $request)
    {
        $authId = Auth::id();

        $contactIds = Message::where('from_id', $authId)->orWhere('to_id', $authId)->select(["from_id", "to_id"])
            ->groupBy("from_id", "to_id")
            ->get()
            ->map(function ($user) use ($authId) {
                return ($user->from_id != $authId) ? $user->from_id : $user->to_id;
            })
            ->unique();


        $users = User::whereIntegerInRaw("id", $contactIds)
            ->get(["id", "name", 'email']);

        $view = view('Frontend.Chat.ajax.coversation-user-list', compact('users'))->render();

        return response()->json([
            'view' => $view,
        ]);
    }
}
