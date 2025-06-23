<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use App\Models\Report;

class AuthController extends Controller
{
    public function showLogin() {
        return view('auth.login');
    }

    public function showRegister() {
        return view('auth.register');
    }

    public function login(Request $request) {
    $request->validate([
        'email' => 'required|email|max:255|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
        'password' => [
            'required',
            'string',
            'min:8',
            'regex:/^[\w!@#$%^&*()-=+{}\[\]:;"\'<>,.?\/]+$/',
        ],
    ]);

    $credentials = $request->only('email', 'password');
    $remember = $request->has('remember');
    $totalReports = Report::where('reported_id', $currentUser->id)->count();

    if (preg_match('/(=|--|\b(OR|AND)\b)/i', $request->password)) {
        return back()->withErrors(['password' => 'Password contains invalid characters.']);
    }

    if ($totalReports >= 3) {
        return back()->withErrors(['login' => 'This user has been banned due to multiple reports.']);
    } elseif ($totalReports >= 1) {
        $user = User::where('email', $credentials['email'])->where('status', '!=', 'banned')->first();
        if (!$user) {
            return back()->withErrors(['login' => 'User not found or banned.']);
        }
    } else {
        $user = User::where('email', $credentials['email'])->first();
        if (!$user) {
            return back()->withErrors(['login' => 'User not found.']);
        }
    }

    if (Auth::attempt($credentials, $remember)) {
        return redirect()->intended('/');
    }

    return back()->withErrors(['email' => 'Invalid email or password.']);
}

    public function register(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'email' => 'required|string|email|max:255|unique:users|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^[\w!@#$%^&*()-=+{}\[\]:;"\'<>,.?\/]+$/'
            ],
        ]);

        if (!$request->has('email') || !$request->has('password') || !$request->has('name')) {
            return back()->withErrors(['register' => 'Incomplete data provided.']);
        }

        $user = User::create([
            'name' => strip_tags($request->name),
            'email' => strtolower($request->email),
            'password' => Hash::make($request->password),
            'role' => 'buyer',
            'photo' => 'public/person.jpeg'
        ]);

        if (!$user) {
            return back()->withErrors(['register' => 'Registration failed. Please try again.']);
        }

        $remember = $request->has('remember');

        Auth::login($user, $remember);
        if (!$request->has('remember')) {
            Auth::login($user, false);
        }

        return redirect()->route('welcome')->with('message', 'Registration successful');
    }

    public function showForgotPassword() {
        return view('auth.forgot-password');
    }
    public function sendResetLink(Request $request) {
        // Logic to send password reset link
        return response()->json(['message' => 'Password reset link sent']);
    }
    public function showResetPassword($token) {
        return view('auth.reset-password', ['token' => $token]);
    }
    public function resetPassword(Request $request) {
        // Logic to reset password
        return response()->json(['message' => 'Password reset successfully']);
    }
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();
        $user = User::firstOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name' => $googleUser->getName(),
                'password' => Hash::make(uniqid()),
                'role' => 'buyer',
                'photo' => 'public/person.jpeg'
            ]
        );
        Auth::login($user, true);
        return redirect()->route('welcome');
    }
    public function logout(Request $request) {
        // Logic to log out user
        auth()->logout();
        return redirect()->route('welcome')->with('message', 'Logged out successfully');
    }
}
