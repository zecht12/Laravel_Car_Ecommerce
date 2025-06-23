<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Report;


class UserController extends Controller
{
    public function profile($id = null)
    {
        $currentUser = Auth::user();
        $viewingOwnProfile = false;
        $totalReports = Report::where('reported_id', $currentUser->id)->count();

        if (!$id || $id == $currentUser->id) {
            $user = $currentUser;
            $viewingOwnProfile = true;
        } elseif ($totalReports >= 3) {
            return redirect()->back()->withErrors(['error' => 'This user has been banned due to multiple reports.']);
        } elseif ($totalReports >= 1) {
            $user = User::where('id', $id)->where('status', '!=', 'banned')->first();
            if (!$user) {
                return redirect()->back()->withErrors(['error' => 'User not found or banned.']);
            }
        }
        else {
            $user = User::findOrFail($id);
        }

        $likedCars = $user->favorites()->with('car')->get()->pluck('car');
        $myCars = $user->cars ?? collect();

        return view('profile', compact('user', 'viewingOwnProfile', 'likedCars', 'myCars'));
    }

    public function editProfile($id)
    {
        $user = User::findOrFail($id);

        if (Auth::id() !== $user->id) {
            return redirect()->back()->withErrors(['error' => 'Unauthorized action.']);
        }

        return view('editprofile', compact('user'));
    }

    public function updateProfile(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if (Auth::id() !== $user->id) {
            return redirect()->back()->withErrors(['error' => 'Unauthorized action.']);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => ['nullable', 'string', 'min:8'],
            'image' => 'nullable|image|max:2048',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('user', $filename, 'public');
            $user->photo = json_encode(['user/' . $filename]);
        }

        $user->save();

        return redirect()->route('profile', $user->id)->with('success', 'Profile updated successfully.');
    }
}
