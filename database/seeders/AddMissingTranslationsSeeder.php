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
            // Home Page
            'home.welcome' => 'Welcome!',
            'home.welcome.ar' => 'مرحباً!',
            'home.total_projects' => 'Total Projects',
            'home.total_projects.ar' => 'المشاريع الإجمالية',
            'home.total_products' => 'Total Products',
            'home.total_products.ar' => 'المنتجات الإجمالية',
            'home.total_clients' => 'Total Clients',
            'home.total_clients.ar' => 'العملاء الإجماليين',
            'home.total_materials' => 'Total Materials',
            'home.total_materials.ar' => 'المواد الإجمالية',
            'home.total_projects_stats' => 'Total Projects',
            'home.total_projects_stats.ar' => 'المشاريع الإجمالية',
            'home.active_projects' => 'Active Projects',
            'home.active_projects.ar' => 'المشاريع النشطة',
            'home.completed_projects' => 'Completed Projects',
            'home.completed_projects.ar' => 'المشاريع المكتملة',
            'home.pending_approval' => 'Pending Approval',
            'home.pending_approval.ar' => 'في انتظار الموافقة',
            'home.technical_pending' => 'Technical Pending',
            'home.technical_pending.ar' => 'في انتظار الفحص الفني',
            'home.projects_in_system' => 'Projects in system',
            'home.projects_in_system.ar' => 'المشاريع في النظام',

            // Sidebar
            'sidebar.dashboard' => 'Dashboard',
            'sidebar.dashboard.ar' => 'لوحة التحكم',
            'sidebar.manage_roles' => 'Manage Roles',
            'sidebar.manage_roles.ar' => 'إدارة الأدوار',
            'sidebar.create_role' => 'Create Role',
            'sidebar.create_role.ar' => 'إنشاء دور',
            'sidebar.view_roles' => 'View Roles',
            'sidebar.view_roles.ar' => 'عرض الأدوار',
            'sidebar.translations' => 'Translations',
            'sidebar.translations.ar' => 'الترجمات',
            'sidebar.manage_permissions' => 'Manage Permissions',
            'sidebar.manage_permissions.ar' => 'إدارة الصلاحيات',
            'sidebar.users' => 'Users',
            'sidebar.users.ar' => 'المستخدمين',
            'sidebar.projects' => 'Projects',
            'sidebar.projects.ar' => 'المشاريع',
            'sidebar.clients' => 'Clients',
            'sidebar.clients.ar' => 'العملاء',
            'sidebar.all_tasks' => 'All Tasks',
            'sidebar.all_tasks.ar' => 'جميع المهام',
            'sidebar.my_tasks' => 'My Tasks',
            'sidebar.my_tasks.ar' => 'مهامي',

            // Common
            'common.total' => 'Total',
            'common.total.ar' => 'إجمالي',
            'common.active' => 'Active',
            'common.active.ar' => 'نشط',
            'common.completed' => 'Completed',
            'common.completed.ar' => 'مكتمل',
            'common.pending' => 'Pending',
            'common.pending.ar' => 'في انتظار',
            'common.approval' => 'Approval',
            'common.approval.ar' => 'موافقة',
            'common.technical' => 'Technical',
            'common.technical.ar' => 'فني',
            'common.system' => 'System',
            'common.system.ar' => 'النظام',
            'common.in_system' => 'In System',
            'common.in_system.ar' => 'في النظام',
            'common.view' => 'View',
            'common.view.ar' => 'عرض',
            'common.create' => 'Create',
            'common.create.ar' => 'إنشاء',
            'common.edit' => 'Edit',
            'common.edit.ar' => 'تعديل',
            'common.delete' => 'Delete',
            'common.delete.ar' => 'حذف',
            'common.confirm_delete' => 'Are you sure you want to delete this item?',
            'common.confirm_delete.ar' => 'هل أنت متأكد من حذف هذا العنصر؟',

            // Suppliers (already added)
            'suppliers.title' => 'Suppliers',

            // Permissions
            'permissions.title' => 'Permissions',
            'permissions.title.ar' => 'الصلاحيات',
            'permissions.manage.title' => 'Manage Permissions',
            'permissions.manage.title.ar' => 'إدارة الصلاحيات',
            'permissions.create.title' => 'Create Permission',
            'permissions.create.title.ar' => 'إنشاء صلاحية',
            'permissions.create.new' => 'Create New Permission',
            'permissions.create.new.ar' => 'إنشاء صلاحية جديدة',
            'permissions.edit.title' => 'Update Permission',
            'permissions.edit.title.ar' => 'تحديث الصلاحية',
            'permissions.name' => 'Permission Name',
            'permissions.name.ar' => 'اسم الصلاحية',
            'permissions.actions' => 'Actions',
            'permissions.actions.ar' => 'الإجراءات',
            'permissions.error.title' => 'Whoops!',
            'permissions.error.title.ar' => 'عذراً!',
            'permissions.error.message' => 'Please fix the errors below.',
            'permissions.error.message.ar' => 'الرجاء إصلاح الأخطاء أدناه.',
            'permissions.search' => 'Search permissions...',
            'permissions.search.ar' => 'ابحث عن الصلاحيات...',
            'permissions.edit.button' => 'Edit',
            'permissions.edit.button.ar' => 'تعديل',
            'permissions.delete.button' => 'Delete',
            'permissions.delete.button.ar' => 'حذف',
            'permissions.save.button' => 'Update Permission',
            'permissions.save.button.ar' => 'تحديث الصلاحية',
            'permissions.table.name' => 'Permission Name',
            'permissions.table.name.ar' => 'اسم الصلاحية',
            'permissions.table.actions' => 'Actions',
            'permissions.table.actions.ar' => 'الإجراءات',
            'suppliers.create.title' => 'Add New Supplier',
            'suppliers.table.name' => 'Name',
            'suppliers.table.location' => 'Location',
            'suppliers.table.contact' => 'Contact',
            'suppliers.table.actions' => 'Actions',
            'suppliers.buttons.view' => 'View',
            'suppliers.buttons.edit' => 'Edit',
            'suppliers.buttons.delete' => 'Delete',
            'suppliers.delete.confirm' => 'Are you sure you want to delete this supplier?',
            'suppliers.delete.confirm.ar' => 'هل أنت متأكد من حذف هذا المورد؟',
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
            'suppliers.title.ar' => 'الموردين',
            'suppliers.create.title.ar' => 'إضافة مورد جديد',
            'suppliers.table.name.ar' => 'الاسم',
            'suppliers.table.location.ar' => 'الموقع',
            'suppliers.table.contact.ar' => 'الاتصال',
            'suppliers.table.actions.ar' => 'الإجراءات',
            'suppliers.buttons.view.ar' => 'عرض',
            'suppliers.buttons.edit.ar' => 'تعديل',
            'suppliers.buttons.delete.ar' => 'حذف',
            'suppliers.delete.confirm.ar' => 'هل أنت متأكد من حذف هذا المورد؟',
            
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

        // Create translations array for messages.php
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
