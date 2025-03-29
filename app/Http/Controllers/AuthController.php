<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        //dd(Hash::make('password')); //utk enskripsi password yang dibuat
        return view('login');
    }

    public function showHomePage()
    {
        $user = Auth::user();
        return view('home', compact('user'));
    }

    public function login(Request $request)
    {
        $credentials = $request->validate(
            [
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]
        );

        if(Auth::attempt($credentials)) {
            return redirect('/home');
        }

        return back()->with('error', 'Email or Password is incorrect');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
