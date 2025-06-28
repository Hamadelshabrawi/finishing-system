<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Translation;

class AddMissingTranslationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $translations = [
            // Dashboard
            'dashboard.title' => 'Dashboard',
            
            // Users
            'users.title' => 'Users',
            'users.create.title' => 'Create User',
            'users.edit.title' => 'Edit User',
            'users.table.name' => 'Name',
            'users.table.email' => 'Email',
            'users.table.role' => 'Role',
            'users.table.actions' => 'Actions',
            'users.form.name' => 'Full Name',
            'users.form.email' => 'Email Address',
            'users.form.password' => 'Password',
            'users.form.password_confirmation' => 'Confirm Password',
            'users.form.new_password' => 'New Password (Optional)',
            'users.form.role' => 'Role',
            'users.form.password_helper' => 'Leave blank if you don\'t want to change the password.',
            'users.roles.admin' => 'Admin',
            'users.roles.technical' => 'Technical',
            'users.roles.financial' => 'Financial',
            'users.roles.operations_manager' => 'Operations Manager',
            'users.roles.storekeeper' => 'Storekeeper',
            'users.roles.user' => 'User',
            
            // Roles
            'roles.title' => 'Manage Roles',
            'roles.create.title' => 'Create Role',
            'roles.view.title' => 'View Roles',
            
            // Permissions
            'permissions.title' => 'Manage Permissions',
            
            // Projects
            'projects.title' => 'Projects',
            
            // Clients
            'clients.title' => 'Clients',
            
            // Tasks
            'tasks.title' => 'Tasks',
            'tasks.all' => 'All Tasks',
            'tasks.my' => 'My Tasks',
            
            // Items
            'items.title' => 'Items',
            
            // Suppliers
            'suppliers.title' => 'Suppliers',
            'suppliers.create.title' => 'Add New Supplier',
            'suppliers.table.name' => 'Name',
            'suppliers.table.location' => 'Location',
            'suppliers.table.contact' => 'Contact',
            'suppliers.table.actions' => 'Actions',
            'suppliers.buttons.view' => 'View',
            'suppliers.buttons.edit' => 'Edit',
            'suppliers.buttons.delete' => 'Delete',
            'suppliers.delete.confirm' => 'Are you sure you want to delete this supplier?',
            
            // Email
            'email.title' => 'Send Email',
            
            // Common
            'common.buttons.create' => 'Create',
            'common.buttons.edit' => 'Edit',
            'common.buttons.delete' => 'Delete',
            'common.buttons.profile' => 'Profile',
            'common.buttons.logout' => 'Logout',
            
            // Navigation
            'nav.home' => 'Home',
            'nav.dashboard' => 'Dashboard',
            'nav.login' => 'Log in',
            'nav.register' => 'Register',
            'nav.documentation' => 'Documentation',
            'nav.laracasts' => 'Laracasts',
            'nav.laravel_news' => 'Laravel News',
            'nav.ecosystem' => 'Vibrant Ecosystem',
            
            // Language
            'language.english' => 'English (EN)',
            'language.arabic' => 'العربية (AR)',
            
            // Validation
            'validation.required' => 'The :attribute field is required.',
            'validation.email' => 'The :attribute must be a valid email address.',
            'validation.min.string' => 'The :attribute must be at least :min characters.',
            'validation.unique' => 'The :attribute has already been taken.',
            'validation.confirmed' => 'The :attribute confirmation does not match.',
            
            // Notifications
            'notifications.title' => 'Notifications',
            
            // Profile
            'profile.title' => 'Profile',
            'profile.avatar' => 'Profile Image',
            
            // Translations
            'translations.title' => 'Translations',
            'translations.description' => 'System translation',
        ];

        foreach ($translations as $key => $value) {
            $arabic = $this->generateArabicTranslation($value);
            Translation::updateOrCreate(
                ['key' => $key],
                [
                    'value_en' => $value,
                    'value_ar' => $arabic,
                    'group' => 'messages',
                    'is_active' => true,
                    'description' => 'System translation',
                ]
            );
        }
    }

    private function generateArabicTranslation(string $english): string
    {
        // This is a placeholder function. In a real application, you would use a proper translation service
        // or manually provide Arabic translations.
        return 'ترجمة ' . $english;
    }
}
