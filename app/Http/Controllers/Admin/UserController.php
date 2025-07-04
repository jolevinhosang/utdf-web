<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // List all admin users
    public function index()
    {
        if (auth()->user()->role === 'superadmin') {
            $users = User::all();
        } else {
            $users = User::where('role', 'admin')->get();
        }
        return view('admin.users', compact('users'));
    }

    // Create a new admin user
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,superadmin',
        ]);

        // Only superadmin can create another superadmin
        if ($request->role === 'superadmin' && auth()->user()->role !== 'superadmin') {
            return redirect()->route('admin.users')->with('error', 'Only superadmin can create another superadmin.');
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users')->with('success', 'User created successfully.');
    }

    // Delete an admin user
    public function destroy(User $user)
    {
        if (auth()->user()->role !== 'superadmin') {
            return redirect()->route('admin.users')->with('error', 'Only superadmin can delete users.');
        }
        $user->delete();
        return redirect()->route('admin.users')->with('success', 'User deleted successfully.');
    }
} 