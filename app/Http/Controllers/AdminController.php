<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Logic for the admin dashboard
        $userCount = User::count();
        $newUsersThisMonth = User::whereMonth('created_at', now()->month)->count();
        // dd($userCount, $newUsersThisMonth);
        return view('admin.dashboard.index', compact('userCount', 'newUsersThisMonth'));
    }

    // Add more admin-related methods here as needed
}
