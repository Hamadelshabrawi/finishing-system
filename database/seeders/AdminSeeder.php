<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
            'type' => 'admin'
        ]);

        // Get admin role
        $role = Role::findByName('Admin');

        // Get all permissions
        $permissions = Permission::all();

        // Assign all permissions to admin role
        $role->syncPermissions($permissions);

        // Assign admin role to admin user
        $admin->assignRole($role);
    }
}
