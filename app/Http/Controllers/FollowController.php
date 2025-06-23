<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Follow;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    public function follow(Request $request, $id) {
        $followerId = Auth::id();
        $followedId = $id;

        if ($followerId == $followedId) {
            return back()->withErrors(['error' => 'You cannot follow yourself.']);
        }

        Follow::firstOrCreate([
            'follower_id' => $followerId,
            'followed_id' => $followedId,
        ]);

        return back()->with('success', 'You are now following this user.');
    }

    public function unfollow(Request $request, $id) {
        $followerId = Auth::id();

        Follow::where('follower_id', $followerId)
            ->where('followed_id', $id)
            ->delete();

        return back()->with('success', 'You have unfollowed this user.');
    }
}
