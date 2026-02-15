<?php
// app/Http/Controllers/AuthController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // Debug: Check if user exists
    $user = \App\Models\User::where('email', $credentials['email'])->first();
    
    if (!$user) {
        \Log::info('User not found: ' . $credentials['email']);
        return back()->withErrors(['email' => 'User not found.']);
    }

    \Log::info('User found: ' . $user->email);
    \Log::info('Password check: ' . (\Hash::check($credentials['password'], $user->password) ? 'Match' : 'No match'));

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        
        // Redirect based on user role
        $user = Auth::user();
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'lecturer') {
            return redirect()->route('lecturer.dashboard');
        } else {
            return redirect()->route('student.dashboard');
        }
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ])->onlyInput('email');
}

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}