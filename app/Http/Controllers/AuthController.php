<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Interfaces\LoginInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function index()
    {
        return view('login');
    }

    public function register()
    {
        return view('register');
    }

    public function registerUser(RegisterRequest $request)
    {
        app(LoginInterface::class)->register($request->validated());
        return redirect()->route('login')->with('success', 'Registration successful! Please log in.');
    }

    public function login(LoginRequest $request)
    {
        $request->validate([]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->with('error', 'Invalid email or password.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        return redirect('/')->with('success', 'You have been logged out successfully.');
    }
}
