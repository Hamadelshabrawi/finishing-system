<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Clear existing permissions and roles
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        
        // Create permissions
        $permissions = [
            // Project Management
            'Projects List',
            'Create Project',
            'Edit Project',
            'Delete Project',
            'Send Project Email',
            'Project Details',
            'Export Project',
            
            // Client Management
            'Clients List',
            'Create Client',
            'Edit Client',
            'Delete Client',
            
            // User Management
            'user list',
            'Create User',
            'Edit User',
            'Delete User',
            
            // Role Management
            'Roles List',
            'Create Roles',
            'Edit Role',
            'Delete Role',
            
            // Permission Management
            'Permission List',
            'Create Permission',
            'Edit Permission',
            'Delete Permission',
            
            // Email Management
            'Send Email',
            
            // Items Management
            'Items List',
            // Products Management
            'Products List'
        ];

        // Create all permissions if they don't exist
        foreach ($permissions as $permission) {
            if (!Permission::where('name', $permission)->exists()) {
                Permission::create(['name' => $permission]);
            }
        }

        // Create roles
        $roles = [
            'Admin',
            'Manager',
            'User'
        ];

        // Create roles if they don't exist
        foreach ($roles as $role) {
            if (!Role::where('name', $role)->exists()) {
                Role::create(['name' => $role]);
            }
        }

        // Assign permissions to roles
        $adminRole = Role::findByName('Admin');
        $adminRole->syncPermissions(Permission::all());

        // Create admin user if they don't exist
        $adminUser = User::where('email', 'admin@admin.com')->first();
        if (!$adminUser) {
            $adminUser = User::create([
                'name' => 'Admin User',
                'email' => 'admin@admin.com',
                'password' => bcrypt('password'),
                'user_type' => 'admin'
            ]);
        }

        // Assign admin role to admin user
        $adminUser->assignRole('Admin');

        // Assign specific permissions to Manager role
        $managerRole = Role::findByName('Manager');
        $managerRole->syncPermissions([
            'Projects List',
            'Create Project',
            'Edit Project',
            'Delete Project',
            'Send Project Email',
            'Clients List',
            'Create Client',
            'Edit Client',
            'Delete Client',
            'Items List'
        ]);

        // Assign specific permissions to User role
        $userRole = Role::findByName('User');
        $userRole->syncPermissions([
            'Projects List',
            'Items List',
            'Clients List'
        ]);
    }
}