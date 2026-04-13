<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // Show login page
    public function showLogin()
    {
        return view('auth.login');
    }

    // Show register page
    public function showRegister()
    {
        return view('auth.register');
    }

    // Handle login form submission
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $role = Auth::user()->role;

            if ($role === 'doctor') {
                return redirect('/doctor/dashboard');
            } elseif ($role === 'assistant') {
                return redirect('/assistant/dashboard');
            } else {
                return redirect('/patient/dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'These credentials do not match our records.',
        ]);
    }


    // Handle register form submission
    public function register(Request $request)
    {
        $request->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'lastname'  => ['required', 'string', 'max:255'],
            'email'     => ['required', 'email', 'unique:users'],
            'password'  => ['required', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'firstname' => $request->firstname,
            'lastname'  => $request->lastname,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role'      => 'patient',
        ]);

        // Automatically create a patient record
        \App\Models\Patient::create([
            'user_id' => $user->id,
        ]);

        Auth::login($user);
        return redirect('/patient/dashboard');
    }

    // Handle logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
