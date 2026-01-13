<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class UpdateTranslationsInViews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translations:update-views';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update views to use translations';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $viewsPath = base_path('resources/views');
        $files = File::allFiles($viewsPath);
        
        $translations = [
            // Users Module
            'Create User' => '__("users.create.title")',
            'Edit User' => '__("users.edit.title")',
            'Full Name' => '__("users.form.name")',
            'Email Address' => '__("users.form.email")',
            'Password' => '__("users.form.password")',
            'Confirm Password' => '__("users.form.password_confirmation")',
            'New Password (Optional)' => '__("users.form.new_password")',
            'Role' => '__("users.form.role")',
            'Leave blank if you don\'t want to change the password.' => '__("users.form.password_helper")',
            
            // Roles
            'Admin' => '__("users.roles.admin")',
            'Technical' => '__("users.roles.technical")',
            'Financial' => '__("users.roles.financial")',
            'Operations Manager' => '__("users.roles.operations_manager")',
            'Storekeeper' => '__("users.roles.storekeeper")',
            'User' => '__("users.roles.user")',
            
            // Buttons
            'Edit' => '__("common.buttons.edit")',
            'Delete' => '__("common.buttons.delete")',
            
            // Welcome Page
            'Home' => '__("welcome.nav.home")',
            'Log in' => '__("welcome.nav.login")',
            'Register' => '__("welcome.nav.register")',
            'Documentation' => '__("welcome.sections.documentation")',
            'Laracasts' => '__("welcome.sections.laracasts")',
            'Laravel News' => '__("welcome.sections.laravel_news")',
            'Vibrant Ecosystem' => '__("welcome.sections.ecosystem")',
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
        
        $this->info('Views have been updated with translations');
    }
}
