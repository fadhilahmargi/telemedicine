<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class HomeController extends Controller
{
    public function showHomePage()
    {
        $auth = Auth::user();
        $users = User::where('id', '!=', $auth->id)->get();
        return view('home', compact('auth', 'users'));
    }

    public function showProfilePage($username)
    {
        $auth = Auth::user();
        $users = User::where('id', '!=', $auth->id)->get();
        $profile = User::where('username', $username)->firstOrFail();
        return view('profile', compact('auth', 'users', 'profile'));
    }

    public function search (request $request){
        $searchValue = $request->validate([
            'search' => 'required|string|max:50',
        ]);

        $search = $searchValue['search'];
        $users = User::where('name', 'LIKE', "%{$search}%")
            ->orWhere('username', 'LIKE', "%{$search}%")
            ->get();

        return response()->json($users);
    }

    public function getUser(Request $request){
        $userId = $request->input('id');

        if($userId){
            $user = User::findOrFail($userId);
        }else{
            $user = Auth::user();
        }

        return response()->json($user);
    }

}
