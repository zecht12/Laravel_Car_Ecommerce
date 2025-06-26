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
        $currentUserId = Auth::id();

        Chat::where('from_user', $userId)
            ->where('to_user', $currentUserId)
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        $messages = Chat::where(function ($query) use ($currentUserId, $userId) {
                $query->where('from_user', $currentUserId)
                    ->where('to_user', $userId);
            })
            ->orWhere(function ($query) use ($currentUserId, $userId) {
                $query->where('from_user', $userId)
                    ->where('to_user', $currentUserId);
            })
            ->where('is_deleted', false)
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
            'chat_type' => 'text',
            'is_read' => false,
            'is_deleted' => false,
            'is_archived' => false,
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

    public function destroy($id)
    {
        $message = Chat::where('id', $id)
            ->where(function ($q) {
                $q->where('from_user', Auth::id())->orWhere('to_user', Auth::id());
            })
            ->firstOrFail();

        $message->update([
            'is_deleted' => true,
            'deleted_at' => now(),
            'status' => 'deleted',
        ]);

        return redirect()->back()->with('success', 'Message deleted!');
    }
}

