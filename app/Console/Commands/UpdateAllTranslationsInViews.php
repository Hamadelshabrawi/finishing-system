<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class UpdateAllTranslationsInViews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translations:update-all-views';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update all views to use translations';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $viewsPath = base_path('resources/views');
        $files = File::allFiles($viewsPath);
        
        $translations = [
            // Common
            'Create' => '__("common.buttons.create")',
            'Edit' => '__("common.buttons.edit")',
            'Delete' => '__("common.buttons.delete")',
            'Profile' => '__("common.buttons.profile")',
            'Logout' => '__("common.buttons.logout")',
            
            // Dashboard
            'Dashboard' => '__("dashboard.title")',
            
            // Users
            'Users' => '__("users.title")',
            'Create User' => '__("users.create.title")',
            'Edit User' => '__("users.edit.title")',
            'Name' => '__("users.table.name")',
            'Email' => '__("users.table.email")',
            'Role' => '__("users.table.role")',
            'Actions' => '__("users.table.actions")',
            'Full Name' => '__("users.form.name")',
            'Email Address' => '__("users.form.email")',
            'Password' => '__("users.form.password")',
            'Confirm Password' => '__("users.form.password_confirmation")',
            'New Password (Optional)' => '__("users.form.new_password")',
            'Leave blank if you don\'t want to change the password.' => '__("users.form.password_helper")',
            'Admin' => '__("users.roles.admin")',
            'Technical' => '__("users.roles.technical")',
            'Financial' => '__("users.roles.financial")',
            'Operations Manager' => '__("users.roles.operations_manager")',
            'Storekeeper' => '__("users.roles.storekeeper")',
            'User' => '__("users.roles.user")',
            
            // Roles
            'Manage Roles' => '__("roles.title")',
            'Create Role' => '__("roles.create.title")',
            'View Roles' => '__("roles.view.title")',
            
            // Permissions
            'Manage Permissions' => '__("permissions.title")',
            
            // Projects
            'Projects' => '__("projects.title")',
            
            // Clients
            'Clients' => '__("clients.title")',
            
            // Tasks
            'Tasks' => '__("tasks.title")',
            'All Tasks' => '__("tasks.all")',
            'My Tasks' => '__("tasks.my")',
            
            // Items
            'Items' => '__("items.title")',
            
            // Suppliers
            'Suppliers' => '__("suppliers.title")',
            
            // Email
            'Send Email' => '__("email.title")',
            
            // Navigation
            'Home' => '__("nav.home")',
            'Dashboard' => '__("nav.dashboard")',
            'Log in' => '__("nav.login")',
            'Register' => '__("nav.register")',
            'Documentation' => '__("nav.documentation")',
            'Laracasts' => '__("nav.laracasts")',
            'Laravel News' => '__("nav.laravel_news")',
            'Vibrant Ecosystem' => '__("nav.ecosystem")',
            
            // Language
            'English (EN)' => '__("language.english")',
            'العربية (AR)' => '__("language.arabic")',
            
            // Profile
            'Profile' => '__("profile.title")',
            'Profile Image' => '__("profile.avatar")',
            
            // Translations
            'Translations' => '__("translations.title")',
        ];

        foreach ($files as $file) {
            if ($file->getExtension() !== 'blade.php') continue;
            
            $content = File::get($file->getPathname());
            
            foreach ($translations as $text => $translation) {
                // Replace the text with translation function
                $content = str_replace($text, $translation, $content);
            }
            
            File::put($file->getPathname(), $content);
        }
        
        $this->info('All views have been updated with translations');
    }
}
