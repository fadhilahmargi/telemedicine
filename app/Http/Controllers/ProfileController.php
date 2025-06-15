<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Jika ada upload foto baru
        if ($request->hasFile('photo')) {
            if ($user->profileImage && Storage::disk('public')->exists($user->profileImage)) {
                Storage::disk('public')->delete($user->profileImage);
            }
            $path = $request->file('photo')->store('profile_photos', 'public');
            $user->profileImage = $path;
        }

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        //$user->save();

        // Jika AJAX, return JSON
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Profile updated!',
                'profileImage' => $user->profileImage ? asset('storage/' . $user->profileImage) : asset('images/default-profile.png'),
                'name' => $user->name,
                'email' => $user->email,
            ]);
        }

        // Jika bukan AJAX, redirect biasa
        return redirect()->route('profile.edit')->with('success', 'Profile updated!');
    }
}
