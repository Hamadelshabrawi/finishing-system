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
        
        // Create permissions if they don't exist
        // Dashboard
        Permission::firstOrCreate(['name' => 'dashboard', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'view_timeline', 'guard_name' => 'web']);

        // Email Management
        Permission::firstOrCreate(['name' => 'send_email', 'guard_name' => 'web']);

        // Items Management
        Permission::firstOrCreate(['name' => 'Items List', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Create Item', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Edit Item', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Delete Item', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'View Item Data', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Create Item Purchase', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Edit Item Purchase', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Delete Item Purchase', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Consume Item', 'guard_name' => 'web']);

        // Permission Management
        Permission::firstOrCreate(['name' => 'Permission List', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Create Permission', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Edit Permission', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Delete Permission', 'guard_name' => 'web']);

        // Project Management
        Permission::firstOrCreate(['name' => 'Projects List', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Create Project', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Edit Project', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Delete Project', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'View Project Details', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Export Project', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Send Project Email', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Approve Project', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Upload Project File', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'View Project Tasks', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'View Project Products', 'guard_name' => 'web']);

        // Product Management
        Permission::firstOrCreate(['name' => 'Products List', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Create Product', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Edit Product', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Delete Product', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'View Product Details', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'View Product Files', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'View Product Notes', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'View Final Finish', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Create Product Note', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Edit Product Note', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Delete Product Note', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Upload Product File', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Download Product File', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Delete Product File', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Export Product', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Create Product Note', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Edit Product Note', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Delete Product Note', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Upload Product File', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Download Product File', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Delete Product File', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'View Product Files', 'guard_name' => 'web']);

        // Role Management
        Permission::firstOrCreate(['name' => 'Roles List', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Create Role', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Edit Role', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Delete Role', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Assign Role', 'guard_name' => 'web']);

        // Supplier Management
        Permission::firstOrCreate(['name' => 'Suppliers List', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Create Supplier', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Edit Supplier', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Delete Supplier', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'View Supplier Outsourcing', 'guard_name' => 'web']);

        // Task Management
        Permission::firstOrCreate(['name' => 'Tasks List', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Create Task', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Edit Task', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Delete Task', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'View Task Details', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Assign Task', 'guard_name' => 'web']);

        // Translation Management
        Permission::firstOrCreate(['name' => 'Manage Translations', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'translations_list', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'create_translation', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'edit_translation', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'delete_translation', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Edit Translation', 'guard_name' => 'web']);

        // User Management
        Permission::firstOrCreate(['name' => 'user list', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Create User', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Edit User', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Delete User', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'view_profile', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'edit_profile', 'guard_name' => 'web']);

        // Client Management
        Permission::firstOrCreate(['name' => 'Clients List', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Create Client', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Edit Client', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Delete Client', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Search Clients', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'View Client Details', 'guard_name' => 'web']);

        // Create roles if they don't exist
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $managerRole = Role::firstOrCreate(['name' => 'Manager']);
        $technicalRole = Role::firstOrCreate(['name' => 'Technical']);
        $userRole = Role::firstOrCreate(['name' => 'User']);

        // Assign permissions to roles
        // Admin gets all permissions
        $adminRole->givePermissionTo(Permission::all());

        // Ensure admin user exists and has admin role
        $adminUser = User::where('email', 'admin@example.com')->first();
        if (!$adminUser) {
            $adminUser = User::create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
                'user_type' => 'Admin'
            ]);
        }

        // Ensure admin user has admin role and all permissions
        $adminRole = Role::where('name', 'Admin')->first();
        if ($adminRole) {
            $adminUser->syncRoles([$adminRole]);
            $adminUser->syncPermissions(Permission::all());
        }
    }
}