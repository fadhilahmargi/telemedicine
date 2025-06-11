<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        //return view('login');
        return view('login')->with('message', 'Muncul dari controller');
    }

    public function showRegisterForm()
    {
        return view('register');
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

        if (Auth::attempt($credentials)) {
            // if user->role is admin, redirect to admin page
            if (Auth::user()->role == 'admin') {
                return redirect('/admin/dashboard');
            }
            // if user->role is penjaga or spesialis, redirect to home page
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

    public function register(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|min:4|max:40',
                'username' => 'required|string|min:4|max:40|unique:users,username',
                'email' => 'required|string|email|unique:users,email',
                'password' => 'required|string|min:4',
            ]
        );

        // dd($request->input('username'));

        $user = User::create([
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        Auth::login($user);

        return redirect()->route('home');
    }
}
