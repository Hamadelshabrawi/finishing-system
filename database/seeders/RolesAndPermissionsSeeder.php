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
        // Dashboard
        Permission::create(['name' => 'Dashboard']);
        Permission::create(['name' => 'View Timeline']);

        // Project Management
        Permission::create(['name' => 'Projects List']);
        Permission::create(['name' => 'Create Project']);
        Permission::create(['name' => 'Edit Project']);
        Permission::create(['name' => 'Delete Project']);
        Permission::create(['name' => 'View Project Details']);
        Permission::create(['name' => 'Export Project']);
        Permission::create(['name' => 'Approve Project']);
        Permission::create(['name' => 'Upload Project File']);
        Permission::create(['name' => 'Send Project Email']);
        Permission::create(['name' => 'View Project Tasks']);
        Permission::create(['name' => 'View Project Products']);

        // Client Management
        Permission::create(['name' => 'Clients List']);
        Permission::create(['name' => 'Create Client']);
        Permission::create(['name' => 'Edit Client']);
        Permission::create(['name' => 'Delete Client']);
        Permission::create(['name' => 'Search Clients']);
        Permission::create(['name' => 'View Client Details']);

        // User Management
        Permission::create(['name' => 'user list']);
        Permission::create(['name' => 'Create User']);
        Permission::create(['name' => 'Edit User']);
        Permission::create(['name' => 'Delete User']);
        Permission::create(['name' => 'Assign Role']);
        Permission::create(['name' => 'View Profile']);
        Permission::create(['name' => 'Edit Profile']);

        // Role Management
        Permission::create(['name' => 'Roles List']);
        Permission::create(['name' => 'Create Role']);
        Permission::create(['name' => 'Edit Role']);
        Permission::create(['name' => 'Delete Role']);
        Permission::create(['name' => 'Assign Permissions']);

        // Permission Management
        Permission::create(['name' => 'Permission List']);
        Permission::create(['name' => 'Create Permission']);
        Permission::create(['name' => 'Edit Permission']);
        Permission::create(['name' => 'Delete Permission']);

        // Email Management
        Permission::create(['name' => 'Send Email']);
        Permission::create(['name' => 'Configure Email']);
        Permission::create(['name' => 'View Email Logs']);

        // Supplier Management
        Permission::create(['name' => 'Suppliers List']);
        Permission::create(['name' => 'Create Supplier']);
        Permission::create(['name' => 'Edit Supplier']);
        Permission::create(['name' => 'Delete Supplier']);
        Permission::create(['name' => 'View Supplier Outsourcing']);

        // Product Management
        Permission::create(['name' => 'Products List']);
        Permission::create(['name' => 'Create Product']);
        Permission::create(['name' => 'Edit Product']);
        Permission::create(['name' => 'Delete Product']);
        Permission::create(['name' => 'View Product Details']);
        Permission::create(['name' => 'Export Product']);

        // Item Management
        Permission::create(['name' => 'Items List']);
        Permission::create(['name' => 'Create Item']);
        Permission::create(['name' => 'Edit Item']);
        Permission::create(['name' => 'Delete Item']);
        Permission::create(['name' => 'View Item Data']);
        Permission::create(['name' => 'Create Item Purchase']);
        Permission::create(['name' => 'Edit Item Purchase']);
        Permission::create(['name' => 'Delete Item Purchase']);
        Permission::create(['name' => 'Consume Item']);

        // Task Management
        Permission::create(['name' => 'Tasks List']);
        Permission::create(['name' => 'Create Task']);
        Permission::create(['name' => 'Edit Task']);
        Permission::create(['name' => 'Delete Task']);
        Permission::create(['name' => 'Assign Task']);
        Permission::create(['name' => 'View Task Details']);

        // Outsourcing Management
        Permission::create(['name' => 'Outsourcing List']);
        Permission::create(['name' => 'Create Outsource']);
        Permission::create(['name' => 'Edit Outsource']);
        Permission::create(['name' => 'Delete Outsource']);
        Permission::create(['name' => 'View Outsource Details']);
        Permission::create(['name' => 'Assign Supplier']);

        // Final Finish Management
        Permission::create(['name' => 'Final Finish List']);
        Permission::create(['name' => 'Create Final Finish']);
        Permission::create(['name' => 'Edit Final Finish']);
        Permission::create(['name' => 'Delete Final Finish']);
        Permission::create(['name' => 'View Final Finish']);

        // Material Management
        Permission::create(['name' => 'Materials List']);
        Permission::create(['name' => 'Create Material']);
        Permission::create(['name' => 'Edit Material']);
        Permission::create(['name' => 'Delete Material']);
        Permission::create(['name' => 'View Material Details']);

        // Product Item Consumption
        Permission::create(['name' => 'Consume Product Item']);
        Permission::create(['name' => 'View Product Item Consumption']);

        // Product Notes
        Permission::create(['name' => 'Create Product Note']);
        Permission::create(['name' => 'Edit Product Note']);
        Permission::create(['name' => 'Delete Product Note']);
        Permission::create(['name' => 'View Product Notes']);

        // Product Files
        Permission::create(['name' => 'Upload Product File']);
        Permission::create(['name' => 'Download Product File']);
        Permission::create(['name' => 'Delete Product File']);
        Permission::create(['name' => 'View Product Files']);

        // Create roles
        $adminRole = Role::create(['name' => 'Admin']);
        $managerRole = Role::create(['name' => 'Manager']);
        $technicalRole = Role::create(['name' => 'Technical']);
        $userRole = Role::create(['name' => 'User']);

        // Assign all permissions to Admin role
        $adminRole->givePermissionTo(Permission::all());

        // Assign permissions to Manager role
        $managerRole->givePermissionTo([
            'Dashboard',
            'View Timeline',
            'Projects List',
            'Create Project',
            'Edit Project',
            'Delete Project',
            'View Project Details',
            'Export Project',
            'Approve Project',
            'Upload Project File',
            'Send Project Email',
            
            'Clients List',
            'Create Client',
            'Edit Client',
            'Delete Client',
            'Search Clients',
            'View Client Details',
            
            'user list',
            'Create User',
            'Edit User',
            'Delete User',
            'Assign Role',
            'View Profile',
            'Edit Profile',
            
            'Roles List',
            'Create Role',
            'Edit Role',
            'Delete Role',
            'Assign Permissions',
            
            'Permission List',
            'Create Permission',
            'Edit Permission',
            'Delete Permission',
            
            'Send Email',
            'Configure Email',
            'View Email Logs',
            
            'Suppliers List',
            'Create Supplier',
            'Edit Supplier',
            'Delete Supplier',
            'View Supplier Outsourcing',
            
            'Products List',
            'Create Product',
            'Edit Product',
            'Delete Product',
            'View Product Details',
            'Export Product',
            
            'Items List',
            'Create Item',
            'Edit Item',
            'Delete Item',
            'View Item Data',
            'Create Item Purchase',
            'Edit Item Purchase',
            'Delete Item Purchase',
            'Consume Item',
            
            'Tasks List',
            'Create Task',
            'Edit Task',
            'Delete Task',
            'Assign Task',
            'View Task Details',
            
            'Outsourcing List',
            'Create Outsource',
            'Edit Outsource',
            'Delete Outsource',
            'View Outsource Details',
            'Assign Supplier',
            
            'Final Finish List',
            'Create Final Finish',
            'Edit Final Finish',
            'Delete Final Finish',
            'View Final Finish',
            
            'Materials List',
            'Create Material',
            'Edit Material',
            'Delete Material',
            'View Material Details',
            
            'Consume Product Item',
            'View Product Item Consumption',
            
            'Create Product Note',
            'Edit Product Note',
            'Delete Product Note',
            'View Product Notes',
            
            'Upload Product File',
            'Download Product File',
            'Delete Product File',
            'View Product Files'
        ]);

        // Assign permissions to Technical role
        $technicalRole->givePermissionTo([
            'Dashboard',
            'View Timeline',
            'Projects List',
            'View Project Details',
            'Export Project',
            
            'Clients List',
            'View Client Details',
            
            'user list',
            'View Profile',
            
            'Send Email',
            
            'Suppliers List',
            'View Supplier Outsourcing',
            
            'Products List',
            'View Product Details',
            'Export Product',
            
            'Items List',
            'View Item Data',
            'Consume Item',
            
            'Tasks List',
            'Create Task',
            'Edit Task',
            'View Task Details',
            
            'Outsourcing List',
            'View Outsource Details',
            'Assign Supplier',
            
            'Final Finish List',
            'Create Final Finish',
            'Edit Final Finish',
            'View Final Finish',
            
            'Materials List',
            'View Material Details',
            
            'View Product Item Consumption',
            
            'View Product Notes',
            
            'View Product Files'
        ]);

        // Assign permissions to User role
        $userRole->givePermissionTo([
            'Dashboard',
            'View Timeline',
            'Projects List',
            'View Project Details',
            
            'Clients List',
            'View Client Details',
            
            'user list',
            'View Profile',
            
            'Send Email',
            
            'Suppliers List',
            'View Supplier Outsourcing',
            
            'Products List',
            'View Product Details',
            
            'Items List',
            'View Item Data',
            
            'Tasks List',
            'View Task Details',
            
            'Outsourcing List',
            'View Outsource Details',
            
            'Final Finish List',
            'View Final Finish',
            
            'Materials List',
            'View Material Details',
            
            'View Product Item Consumption',
            
            'View Product Notes',
            
            'View Product Files'
        ]);

        // Assign roles to users
        $admin = User::where('email', 'admin@example.com')->first();
        $manager = User::where('email', 'manager@example.com')->first();
        $user = User::where('email', 'user@example.com')->first();

        if ($admin) {
            $admin->assignRole('Admin');
        }
        if ($manager) {
            $manager->assignRole('Manager');
        }
        if ($user) {
            $user->assignRole('User');
        }

        // Create admin user if they don't exist
        $adminUser = User::where('email', 'admin@admin.com')->first();
        if (!$adminUser) {
            $adminUser = User::create([
                'name' => 'Admin User',
                'email' => 'admin@admin.com',
                'password' => bcrypt('password'),
                'user_type' => 'Admin'
            ]);
        }

        // Assign admin role to admin user
        $adminUser->assignRole('Admin');
    }
}