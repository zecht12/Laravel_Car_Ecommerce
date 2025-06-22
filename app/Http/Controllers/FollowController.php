<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Follow;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    public function follow(Request $request, $id)
    {
        $buyerId = Auth::id();

        if ($buyerId == $id) {
            return redirect()->back()->withErrors(['error' => 'You cannot follow yourself.']);
        }

        // Prevent duplicate follow
        Follow::firstOrCreate([
            'buyer_id' => $buyerId,
            'seller_id' => $id,
        ]);

        return redirect()->back()->with('success', 'You are now following this user.');
    }

    public function unfollow(Request $request, $id)
    {
        $buyerId = Auth::id();

        Follow::where('buyer_id', $buyerId)
            ->where('seller_id', $id)
            ->delete();

        return redirect()->back()->with('success', 'You have unfollowed this user.');
    }
}
