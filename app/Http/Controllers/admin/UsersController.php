<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {
        // Logic for listing users
        $users = User::whereIn('role', ['penjaga', 'spesialis'])->get();
        // dd($users->toArray());
        // $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    // Tambahkan method store di bawah ini
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|string',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'username' => $validated['email'], // tambahkan ini
            'role' => $validated['role'],
            'password' => bcrypt('twiw'),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan!');
    }
    // Tambahkan method edit di bawah ini

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'role' => 'required|string',
            // password tidak required
            'password' => 'nullable|string|min:6',
        ]);

        // Jika password diisi, update password
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        } else {
            // Jika password kosong, hapus dari $data agar tidak diupdate
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'User updated!');
    }

    // Tambahkan method destroy di bawah ini
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus!');
    }
    public function toggle($id)
    {
        $user = \App\Models\User::findOrFail($id);
        $user->is_active = !$user->is_active;
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User status updated!');
    }
    public function listActiveDoctors()
    {
        $doctors = User::where('role', 'spesialis')
            ->where('is_active', true)
            ->get();

        return view('components.doctor-select', compact('doctors'));
    }
}
