<?php

namespace App\Http\Controllers\Frontend\Chat;

use App\Events\ClientTyping;
use App\Events\MessageSentEvent;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Pusher\Pusher;

class ChatController extends Controller
{

    public $pusher;
    function PusherAuth(Request $request)
    {
        \Debugbar::disable();
        $authData = json_encode([
            'user_id' => Auth::user()->id,
            'user_info' => [
                'name' => Auth::user()->name
            ]
        ]);

        $pusher = new Pusher(
            config('broadcasting.connections.pusher.key'),
            config('broadcasting.connections.pusher.secret'),
            config('broadcasting.connections.pusher.app_id'),
            config('broadcasting.connections.pusher.options'),
        );


        $socketId = $request->socket_id;
        $channelName = $request->channel_name;
        return $pusher->socket_auth(
            $request->channel_name,
            $request->socket_id,
            $authData,

        );
    }

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
            ->get(["id", "name", 'email', 'last_seen', 'slug']);

        return view('New.new', compact('users'));
    }
    function ChatSearchUser(Request $request)
    {
        $search = $request->search;
        $users =   User::where('name', 'LIKE', "%$search%")->where('id', '!=', auth()->id())->get();
        $view = view('New.ajax.search-user', compact('users'))->render();

        return response()->json([
            'view' => $view,
        ]);
    }
    function FetchUser($slug)
    {
        $id = $slug;
        $user =  User::where('slug', $id)->first();;

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
            ->get(["id", "name", 'email', 'last_seen', 'slug']);


        $messages =  Message::where(function ($q) {
            $q->where('from_id',  auth()->id())
                ->orWhere('to_id',  auth()->id());
        })->where(function ($q) use ($user) {
            $q->where('to_id', $user->id)
                ->orWhere('from_id', $user->id);
        })->get();

        return view('New.chat', [
            'user' => $user,
            'users' => $users,
            'messages' => $messages,
        ]);
    }
    function SendMessage(Request $request)
    {

        $request->validate([
            'body' => ['required'],
            'to_id' => ['required', 'numeric'],
        ]);

        $user =  User::findorfail($request->to_id);

        session()->put('to_name', $user->name);

        $message = new Message;
        $message->from_id = auth()->id();
        $message->to_id = $request->to_id;
        $message->body = $request->body;
        $message->save();

        broadcast(new MessageSentEvent($user, $message))->toOthers();
    }
    // function Typing(Request $request)
    // {

    //     $request->validate([
    //         'id' => ['required', 'numeric'],
    //     ]);

    //     $user = $request->id;

    //     broadcast(new ClientTyping($user, 'typing'))->toOthers();
    // }
    // function FetchUserList(Request $request)
    // {
    //     $authId = Auth::id();

    //     $contactIds = Message::where('from_id', $authId)->orWhere('to_id', $authId)->select(["from_id", "to_id"])
    //         ->groupBy("from_id", "to_id")
    //         ->get()
    //         ->map(function ($user) use ($authId) {
    //             return ($user->from_id != $authId) ? $user->from_id : $user->to_id;
    //         })
    //         ->unique();


    //     $users = User::whereIntegerInRaw("id", $contactIds)
    //         ->get(["id", "name", 'email']);

    //     $view = view('Frontend.Chat.ajax.coversation-user-list', compact('users'))->render();

    //     return response()->json([
    //         'view' => $view,
    //     ]);
    // }
}
