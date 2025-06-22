<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class UserController extends Controller
{
    public function profile($id = null)
    {
        $currentUser = Auth::user();
        $viewingOwnProfile = false;

        if (!$id || $id == $currentUser->id) {
            $user = $currentUser;
            $viewingOwnProfile = true;
        } else {
            $user = User::findOrFail($id);
        }

        $likedCars = $user->favorites()->with('car')->get()->pluck('car');
        $myCars = $user->cars ?? collect();

        return view('profile', compact('user', 'viewingOwnProfile', 'likedCars', 'myCars'));
    }

    public function updateProfile(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/^[\w!@#$%^&*()-=+{}\[\]:;"\'<>,.?\/]+$/',
            ],
        ]);

        $user = Auth::user();
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }
        if (preg_match('/(=|--|\b(OR|AND)\b)/i', $request->password)) {
            return back()->withErrors(['password' => 'Password contains invalid characters.']);
        }

        $user->save();
        return redirect()->route('profile')->with('success', 'Profile updated successfully.');
    }
}
