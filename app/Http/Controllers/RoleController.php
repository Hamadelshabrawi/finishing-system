<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:Roles List')->only(['index']);
        $this->middleware('can:Create Roles')->only(['create', 'store']);
        $this->middleware('can:Edit Role')->only(['edit', 'update']);
        $this->middleware('can:Delete Role')->only(['destroy']);
    }

    public function index()
    {
        $roles = Role::all();
        return view('roles.index', compact('roles'));
    }

    // Show the form for creating a new role
    public function create()
    {
        $permissions = Permission::all();
        return view('roles.create', compact('permissions'));
    }

    // Store a newly created role
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'array',
        ]);

        $role = Role::create(['name' => $request->name]);

        if ($request->permissions) {
            $role->givePermissionTo($request->permissions);
        }

        return redirect()->route('roles.index')->with('success', 'Role created successfully!');
    }

    // Show the form for editing the specified role
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        return view('roles.edit', compact('role', 'permissions'));
    }

    // Update the specified role
    public function update(Request $request, $id)
    {
        // Validate incoming data
        $request->validate([
            'name' => 'required|unique:roles,name,' . $id,
            'permissions' => 'array|exists:permissions,id', // Ensure permissions exist in the database
        ]);
    
        // Get the role you're updating
        $role = Role::findOrFail($id);
        $role->name = $request->name;
        $role->save();
    
        // Only sync the permissions if the request has permissions
        if ($request->permissions) {
            // Ensure the permissions are integers
            $permissions = array_map('intval', $request->permissions);
            
            // Sync the permissions with the role
            $role->syncPermissions($permissions);
        }
    
        return redirect()->route('roles.index')->with('success', 'Role updated successfully!');
    }
    

    // Remove the specified role
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Role deleted successfully!');
    }
}
