<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index($userId)
    {
        $user = Auth::id();

        $messages = Chat::where(function ($q) use ($user, $userId) {
                $q->where('from_user', $user)->where('to_user', $userId);
            })
            ->orWhere(function ($q) use ($user, $userId) {
                $q->where('from_user', $userId)->where('to_user', $user);
            })
            ->orderBy('sent_at', 'asc')
            ->get();

        return view('chat.pages', compact('messages', 'userId'));
    }

    public function store(Request $request)
    {
        $chat = Chat::create([
            'from_user' => Auth::id(),
            'to_user' => $request->to_user,
            'message' => $request->message,
            'sent_at' => now(),
            'status' => 'sent',
        ]);

        return redirect()->route('chat.index', $request->to_user)->with('success', 'Message sent!');
    }

    public function myChats()
    {
        $userId = Auth::id();

        $chatUserIds = Chat::where('from_user', $userId)
            ->orWhere('to_user', $userId)
            ->selectRaw('IF(from_user = ?, to_user, from_user) as user_id', [$userId])
            ->distinct()
            ->pluck('user_id');

        $users = \App\Models\User::whereIn('id', $chatUserIds)->get();

        return view('chat.my-chats', compact('users'));
    }
}

