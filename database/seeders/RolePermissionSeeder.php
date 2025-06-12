<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{

public function run()
{
    $permissions = [
        // Project related permissions
        'view projects',
        'create projects',
        'edit projects',
        'delete projects',
        'approve projects',
        'view project files',
        'upload project files',
        'delete project files',
        
        // Client related permissions
        'view clients',
        'create clients',
        'edit clients',
        'delete clients',
        
        // Product related permissions
        'view products',
        'create products',
        'edit products',
        'delete products',
        
        // Material related permissions
        'view materials',
        'create materials',
        'edit materials',
        'delete materials',
        
        // Final Finish related permissions
        'view final finishes',
        'create final finishes',
        'edit final finishes',
        'delete final finishes',
        
        // Outsource related permissions
        'view outsources',
        'create outsources',
        'edit outsources',
        'delete outsources',
        
        // System related permissions
        'view system logs',
        'manage users',
        'manage roles',
        'manage permissions'
    ];

    foreach ($permissions as $permission) {
        Permission::firstOrCreate(['name' => $permission]);
    }

    // Create roles
    $roles = [
        'Admin' => 'Super administrator with full access',
        'Manager' => 'System manager with administrative access',
        'User' => 'Regular user'
    ];

    foreach ($roles as $roleName => $description) {
        Role::firstOrCreate(['name' => $roleName], ['description' => $description]);
    }

    // Assign permissions to roles
    $admin = Role::findByName('Admin');
    $manager = Role::findByName('Manager');
    $user = Role::findByName('User');

    // Admin gets all permissions
    $admin->givePermissionTo(Permission::all());

    // Manager role permissions
    $manager->givePermissionTo([
        'view projects',
        'create projects',
        'edit projects',
        'approve projects',
        'view project files',
        'upload project files',
        'delete project files',
        'view clients',
        'create clients',
        'edit clients',
        'delete clients',
        'view products',
        'create products',
        'edit products',
        'delete products',
        'view materials',
        'create materials',
        'edit materials',
        'delete materials',
        'view final finishes',
        'create final finishes',
        'edit final finishes',
        'delete final finishes',
        'view outsources',
        'create outsources',
        'edit outsources',
        'delete outsources'
    ]);

    // User role permissions
    $user->givePermissionTo([
        'view projects',
        'view project files'
    ]);

}

}
