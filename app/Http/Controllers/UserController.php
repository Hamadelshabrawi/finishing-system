<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:user list')->only(['index']);
        $this->middleware('can:Create User')->only(['create', 'store']);
        $this->middleware('can:Edit User')->only(['edit', 'update']);
        $this->middleware('can:Delete User')->only(['destroy']);
    }
    

    public function index() {
        $users = User::orderBy('created_at', 'desc')->get();
        return view('users.index', compact('users'));
    }

    public function create() {
        return view('users.create');
    }

    public function store(Request $request) 
    {
        $validator = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|exists:roles,name' 
        ]);
    
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => $request->role
        ]);

        
        $user->save(); 
        $user->assignRole($request->role);
    
        return redirect()->route('users.index')->withErrors($validator);
    }

    public function edit(User $user) {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required',
            'password' => 'nullable|min:6|confirmed',
        ]);

        $data = $request->only(['name', 'email', 'role']);
    
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        $user->type = $request->input('role');
        $user->assignRole($data['role']);
        $user->update($data);
    
        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }

    public function destroy(User $user) {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }
}