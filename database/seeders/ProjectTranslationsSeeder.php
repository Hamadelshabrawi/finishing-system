<?php

namespace Database\Seeders;

use App\Models\Translation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class ProjectTranslationsSeeder extends Seeder
{
    public function run()
    {
        // Ensure the translations table exists
        if (!Schema::hasTable('translations')) {
            Schema::create('translations', function (Blueprint $table) {
                $table->id();
                $table->string('key')->unique();
                $table->text('value_en')->nullable();
                $table->text('value_ar')->nullable();
                $table->string('group')->default('projects');
                $table->string('description')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        // Check if translations already exist before creating new ones
        $existingKeys = Translation::pluck('key')->toArray();
        
        // Project Management Actions
        $this->createTranslation('project_management', 'Project Management', 'إدارة المشاريع', 'projects');
        $this->createTranslation('create_project', 'Create Project', 'إنشاء مشروع', 'projects');
        $this->createTranslation('edit_project', 'Edit Project', 'تعديل المشروع', 'projects');
        $this->createTranslation('delete_project', 'Delete Project', 'حذف المشروع', 'projects');
        $this->createTranslation('view_project_details', 'View Project Details', 'عرض تفاصيل المشروع', 'projects');
        $this->createTranslation('export_project', 'Export Project', 'تصدير المشروع', 'projects');
        $this->createTranslation('approve_project', 'Approve Project', 'اعتماد المشروع', 'projects');
        $this->createTranslation('upload_project_file', 'Upload Project File', 'رفع ملف المشروع', 'projects');
        $this->createTranslation('send_project_email', 'Send Project Email', 'إرسال بريد إلكتروني للمشروع', 'projects');
        $this->createTranslation('view_project_tasks', 'View Project Tasks', 'عرض مهام المشروع', 'projects');
        $this->createTranslation('view_project_products', 'View Project Products', 'عرض منتجات المشروع', 'projects');
        
        // Client Management Actions
        $this->createTranslation('clients_list', 'Clients List', 'قائمة العملاء', 'clients');
        $this->createTranslation('create_client', 'Create Client', 'إنشاء عميل', 'clients');
        $this->createTranslation('edit_client', 'Edit Client', 'تعديل العميل', 'clients');
        $this->createTranslation('delete_client', 'Delete Client', 'حذف العميل', 'clients');
        $this->createTranslation('search_clients', 'Search Clients', 'بحث عن عملاء', 'clients');
        $this->createTranslation('view_client_details', 'View Client Details', 'عرض تفاصيل العميل', 'clients');
        
        // User Management Actions
        $this->createTranslation('user_list', 'User List', 'قائمة المستخدمين', 'users');
        $this->createTranslation('create_user', 'Create User', 'إنشاء مستخدم', 'users');
        $this->createTranslation('edit_user', 'Edit User', 'تعديل المستخدم', 'users');
        $this->createTranslation('delete_user', 'Delete User', 'حذف المستخدم', 'users');
        $this->createTranslation('assign_role', 'Assign Role', 'تعيين دور', 'users');
        $this->createTranslation('view_profile', 'View Profile', 'عرض الملف الشخصي', 'users');
        $this->createTranslation('edit_profile', 'Edit Profile', 'تعديل الملف الشخصي', 'users');
        
        // Role Management Actions
        $this->createTranslation('roles_list', 'Roles List', 'قائمة الأدوار', 'roles');
        $this->createTranslation('create_role', 'Create Role', 'إنشاء دور', 'roles');
        $this->createTranslation('edit_role', 'Edit Role', 'تعديل الدور', 'roles');
        $this->createTranslation('delete_role', 'Delete Role', 'حذف الدور', 'roles');
        $this->createTranslation('assign_permissions', 'Assign Permissions', 'تعيين الصلاحيات', 'roles');
        
        // Permission Management Actions
        $this->createTranslation('permissions_list', 'Permissions List', 'قائمة الصلاحيات', 'permissions');
        $this->createTranslation('create_permission', 'Create Permission', 'إنشاء صلاحية', 'permissions');
        $this->createTranslation('edit_permission', 'Edit Permission', 'تعديل الصلاحية', 'permissions');
        $this->createTranslation('delete_permission', 'Delete Permission', 'حذف الصلاحية', 'permissions');
        
        // Email Management Actions
        $this->createTranslation('send_email', 'Send Email', 'إرسال بريد إلكتروني', 'email');
        $this->createTranslation('configure_email', 'Configure Email', 'إعداد البريد الإلكتروني', 'email');
        $this->createTranslation('view_email_logs', 'View Email Logs', 'عرض سجلات البريد الإلكتروني', 'email');
        
        // Supplier Management Actions
        $this->createTranslation('suppliers_list', 'Suppliers List', 'قائمة الموردين', 'suppliers');
        $this->createTranslation('create_supplier', 'Create Supplier', 'إنشاء مورد', 'suppliers');
        $this->createTranslation('edit_supplier', 'Edit Supplier', 'تعديل المورد', 'suppliers');
        $this->createTranslation('delete_supplier', 'Delete Supplier', 'حذف المورد', 'suppliers');
        $this->createTranslation('view_supplier_outsourcing', 'View Supplier Outsourcing', 'عرض تفويض المورد', 'suppliers');
        
        // Product Management Actions
        $this->createTranslation('products_list', 'Products List', 'قائمة المنتجات', 'products');
        $this->createTranslation('create_product', 'Create Product', 'إنشاء منتج', 'products');
        $this->createTranslation('edit_product', 'Edit Product', 'تعديل المنتج', 'products');
        $this->createTranslation('delete_product', 'Delete Product', 'حذف المنتج', 'products');
        $this->createTranslation('view_product_details', 'View Product Details', 'عرض تفاصيل المنتج', 'products');
        $this->createTranslation('export_product', 'Export Product', 'تصدير المنتج', 'products');
        
        // Item Management Actions
        $this->createTranslation('items_list', 'Items List', 'قائمة العناصر', 'items');
        $this->createTranslation('create_item', 'Create Item', 'إنشاء عنصر', 'items');
        $this->createTranslation('edit_item', 'Edit Item', 'تعديل العنصر', 'items');
        $this->createTranslation('delete_item', 'Delete Item', 'حذف العنصر', 'items');
        $this->createTranslation('view_item_data', 'View Item Data', 'عرض بيانات العنصر', 'items');
        $this->createTranslation('create_item_purchase', 'Create Item Purchase', 'إنشاء شراء للعنصر', 'items');
        $this->createTranslation('edit_item_purchase', 'Edit Item Purchase', 'تعديل شراء للعنصر', 'items');
        $this->createTranslation('delete_item_purchase', 'Delete Item Purchase', 'حذف شراء للعنصر', 'items');
        $this->createTranslation('consume_item', 'Consume Item', 'استهلاك العنصر', 'items');
        
        // Task Management Actions
        $this->createTranslation('tasks_list', 'Tasks List', 'قائمة المهام', 'tasks');
        $this->createTranslation('create_task', 'Create Task', 'إنشاء مهمة', 'tasks');
        $this->createTranslation('edit_task', 'Edit Task', 'تعديل المهمة', 'tasks');
        $this->createTranslation('delete_task', 'Delete Task', 'حذف المهمة', 'tasks');
        $this->createTranslation('assign_task', 'Assign Task', 'تعيين مهمة', 'tasks');
        $this->createTranslation('view_task_details', 'View Task Details', 'عرض تفاصيل المهمة', 'tasks');
        
        // Outsourcing Management Actions
        $this->createTranslation('outsourcing_list', 'Outsourcing List', 'قائمة التفويض', 'outsourcing');
        $this->createTranslation('create_outsource', 'Create Outsource', 'إنشاء تفويض', 'outsourcing');
        $this->createTranslation('edit_outsource', 'Edit Outsource', 'تعديل التفويض', 'outsourcing');
        $this->createTranslation('delete_outsource', 'Delete Outsource', 'حذف التفويض', 'outsourcing');
        $this->createTranslation('view_outsource_details', 'View Outsource Details', 'عرض تفاصيل التفويض', 'outsourcing');
        $this->createTranslation('assign_supplier', 'Assign Supplier', 'تعيين مورد', 'outsourcing');
        
        // Final Finish Management Actions
        $this->createTranslation('final_finish_list', 'Final Finish List', 'قائمة التشطيب النهائي', 'final_finish');
        $this->createTranslation('create_final_finish', 'Create Final Finish', 'إنشاء تشطيب نهائي', 'final_finish');
        $this->createTranslation('edit_final_finish', 'Edit Final Finish', 'تعديل التشطيب النهائي', 'final_finish');
        $this->createTranslation('delete_final_finish', 'Delete Final Finish', 'حذف التشطيب النهائي', 'final_finish');
        $this->createTranslation('view_final_finish', 'View Final Finish', 'عرض التشطيب النهائي', 'final_finish');
        
        // Material Management Actions
        $this->createTranslation('materials_list', 'Materials List', 'قائمة المواد', 'materials');
        $this->createTranslation('create_material', 'Create Material', 'إنشاء مادة', 'materials');
        $this->createTranslation('edit_material', 'Edit Material', 'تعديل المادة', 'materials');
        $this->createTranslation('delete_material', 'Delete Material', 'حذف المادة', 'materials');
        $this->createTranslation('view_material_details', 'View Material Details', 'عرض تفاصيل المادة', 'materials');
        
        // Product Item Consumption Actions
        $this->createTranslation('consume_product_item', 'Consume Product Item', 'استهلاك عنصر المنتج', 'consumption');
        $this->createTranslation('view_product_item_consumption', 'View Product Item Consumption', 'عرض استهلاك عنصر المنتج', 'consumption');
        
        // Product Notes Actions
        $this->createTranslation('create_product_note', 'Create Product Note', 'إنشاء ملاحظة للمنتج', 'notes');
        $this->createTranslation('edit_product_note', 'Edit Product Note', 'تعديل ملاحظة للمنتج', 'notes');
        $this->createTranslation('delete_product_note', 'Delete Product Note', 'حذف ملاحظة للمنتج', 'notes');
        $this->createTranslation('view_product_notes', 'View Product Notes', 'عرض ملاحظات المنتج', 'notes');
        
        // Product Files Actions
        $this->createTranslation('upload_product_file', 'Upload Product File', 'رفع ملف المنتج', 'files');
        $this->createTranslation('download_product_file', 'Download Product File', 'تحميل ملف المنتج', 'files');
        $this->createTranslation('delete_product_file', 'Delete Product File', 'حذف ملف المنتج', 'files');
        $this->createTranslation('view_product_files', 'View Product Files', 'عرض ملفات المنتج', 'files');

        // Project Management Actions
        $this->createTranslation('project_management', 'Project Management', 'إدارة المشاريع');
        $this->createTranslation('create_project', 'Create Project', 'إنشاء مشروع');
        $this->createTranslation('edit_project', 'Edit Project', 'تعديل المشروع');
        $this->createTranslation('delete_project', 'Delete Project', 'حذف المشروع');
        $this->createTranslation('view_project', 'View Project', 'عرض المشروع');
        $this->createTranslation('project_details', 'Project Details', 'تفاصيل المشروع');
        $this->createTranslation('project_list', 'Project List', 'قائمة المشاريع');
        $this->createTranslation('project_code', 'Project Code', 'كود المشروع');
        $this->createTranslation('project_name', 'Project Name', 'اسم المشروع');
        $this->createTranslation('project_description', 'Project Description', 'وصف المشروع');
        $this->createTranslation('project_contacts', 'Project Contacts', 'اتصالات المشروع');
        
        // Form Labels
        $this->createTranslation('start_date', 'Start Date', 'تاريخ البداية');
        $this->createTranslation('end_date', 'End Date', 'تاريخ النهاية');
        $this->createTranslation('delivery_date', 'Delivery Date', 'تاريخ التسليم');
        $this->createTranslation('technical_approval', 'Technical Approval', 'الموافقة الفنية');
        $this->createTranslation('delivery_location', 'Delivery Location', 'موقع التسليم');
        $this->createTranslation('client_id', 'Client', 'العميل');
        $this->createTranslation('contact_value', 'Project Number', 'رقم المشروع');
        $this->createTranslation('execution_period', 'Execution Period (days)', 'مدة التنفيذ (أيام)');

        // Dashboard
        $this->createTranslation('dashboard', 'Dashboard', 'لوحة التحكم');
        $this->createTranslation('view_timeline', 'View Timeline', 'عرض التسلسل الزمني');
        
        // Contact Fields
        $this->createTranslation('contact_name', 'Contact Name', 'اسم الاتصال');
        $this->createTranslation('contact_position', 'Contact Position', 'موقع الاتصال');
        $this->createTranslation('contact_phone', 'Contact Phone', 'هاتف الاتصال');
        $this->createTranslation('contact_email', 'Contact Email', 'بريد الاتصال');
        
        // File Upload
        $this->createTranslation('upload_initial_files', 'Upload Initial Files (Client Approval Phase)', 'تحميل الملفات الأولية (مرحلة موافقة العميل)');
        $this->createTranslation('drag_drop_files', 'Drag & Drop files here or click to browse', 'اسحب وأفلت الملفات هنا أو انقر لتصفح');
        $this->createTranslation('file_drop_area', 'File Drop Area', 'منطقة إفلات الملفات');
        $this->createTranslation('file_message', 'Drag & Drop files here or click to browse', 'اسحب وأفلت الملفات هنا أو انقر لتصفح');
        $this->createTranslation('file_list', 'File List', 'قائمة الملفات');
        
        // Technical Approval Status
        $this->createTranslation('pending_approval', 'Pending', 'قيد الانتظار');
        $this->createTranslation('approved', 'Approved', 'تمت الموافقة');
        $this->createTranslation('need_modify', 'Need Modify', 'تحتاج تعديل');
        $this->createTranslation('dismissed', 'Dismissed', 'مرفوض');
        
        // Client Information
        $this->createTranslation('client', 'Client', 'العميل');
        $this->createTranslation('client_name', 'Client Name', 'اسم العميل');
        $this->createTranslation('client_company', 'Company Name', 'اسم الشركة');
        $this->createTranslation('select_client', 'Select a client', 'اختر عميلاً');
        
        // Project Status
        $this->createTranslation('status', 'Status', 'الحالة');
        $this->createTranslation('active', 'Active', 'نشط');
        $this->createTranslation('inactive', 'Inactive', 'غير نشط');
        $this->createTranslation('completed', 'Completed', 'مكتمل');
        $this->createTranslation('in_progress', 'In Progress', 'قيد التنفيذ');
        $this->createTranslation('pending', 'Pending', 'قيد الانتظار');
        
        // Project Settings
        $this->createTranslation('project_settings', 'Project Settings', 'إعدادات المشروع');
        $this->createTranslation('setting', 'Setting', 'الإعداد');
        $this->createTranslation('key', 'Key', 'المفتاح');
        $this->createTranslation('value', 'Value', 'القيمة');
        $this->createTranslation('description', 'Description', 'الوصف');
        $this->createTranslation('type', 'Type', 'النوع');
        $this->createTranslation('required', 'Required', 'مطلوب');

        // Project Permissions
        $this->createTranslation('projects_list', 'Projects List', 'قائمة المشاريع');
        $this->createTranslation('create_project', 'Create Project', 'إنشاء مشروع');
        $this->createTranslation('edit_project', 'Edit Project', 'تعديل المشروع');
        $this->createTranslation('delete_project', 'Delete Project', 'حذف المشروع');
        $this->createTranslation('view_project_details', 'View Project Details', 'عرض تفاصيل المشروع');
        $this->createTranslation('export_project', 'Export Project', 'تصدير المشروع');
        $this->createTranslation('approve_project', 'Approve Project', 'موافقة على المشروع');
        $this->createTranslation('upload_project_file', 'Upload Project File', 'تحميل ملف المشروع');
        $this->createTranslation('send_project_email', 'Send Project Email', 'إرسال بريد إلكتروني للمشروع');
        $this->createTranslation('view_project_tasks', 'View Project Tasks', 'عرض مهام المشروع');
        $this->createTranslation('view_project_products', 'View Project Products', 'عرض منتجات المشروع');
        
        // Actions
        $this->createTranslation('actions', 'Actions', 'الإجراءات');
        $this->createTranslation('save', 'Save', 'حفظ');
        $this->createTranslation('cancel', 'Cancel', 'إلغاء');
        $this->createTranslation('confirm_delete', 'Are you sure you want to delete this project?', 'هل أنت متأكد من حذف هذا المشروع؟');
        $this->createTranslation('add_contact', 'Add Contact', 'إضافة اتصال');
        $this->createTranslation('remove_contact', 'Remove Contact', 'إزالة اتصال');
        
        // Messages
        $this->createTranslation('project_created', 'Project created successfully', 'تم إنشاء المشروع بنجاح');
        $this->createTranslation('project_updated', 'Project updated successfully', 'تم تحديث المشروع بنجاح');
        $this->createTranslation('project_deleted', 'Project deleted successfully', 'تم حذف المشروع بنجاح');
        $this->createTranslation('project_not_found', 'Project not found', 'لم يتم العثور على المشروع');
        $this->createTranslation('contact_added', 'Contact added successfully', 'تم إضافة الاتصال بنجاح');
        $this->createTranslation('contact_removed', 'Contact removed successfully', 'تم إزالة الاتصال بنجاح');
        
        // Card Titles
        $this->createTranslation('project_contacts_card', 'Project Contacts', 'اتصالات المشروع');
        $this->createTranslation('client_details_card', 'Client Details', 'تفاصيل العميل');
        $this->createTranslation('project_details_card', 'Project Details', 'تفاصيل المشروع');
        $this->createTranslation('technical_approval_card', 'Technical Approval', 'الموافقة الفنية');
        
        // Modal Text
        $this->createTranslation('add_client', 'Add New Client', 'إضافة عميل جديد');
        $this->createTranslation('client_details', 'Client Details', 'تفاصيل العميل');
        $this->createTranslation('save_client', 'Save Client', 'حفظ العميل');
        $this->createTranslation('cancel_client', 'Cancel', 'إلغاء');
        
        // Validation Messages
        $this->createTranslation('required_field', 'This field is required', 'هذا الحقل مطلوب');
        $this->createTranslation('min_value', 'The minimum value is {0}', 'الحد الأدنى هو {0}');
        $this->createTranslation('invalid_date', 'Invalid date format', 'تنسيق التاريخ غير صحيح');
        $this->createTranslation('invalid_number', 'Invalid number format', 'تنسيق الرقم غير صحيح');
        
        // Show View Specific
        $this->createTranslation('basic_information', 'Basic Information', 'المعلومات الأساسية');
        $this->createTranslation('approvals', 'Approvals', 'الموافقات');
        $this->createTranslation('contract_value', 'Project Number', 'رقم المشروع');
        $this->createTranslation('days', 'days', 'أيام');
        $this->createTranslation('export_pdf_ar', 'Export PDF (Arabic)', 'تصدير PDF (عربي)');
        $this->createTranslation('export_pdf_en', 'Export PDF (English)', 'تصدير PDF (إنجليزي)');
        $this->createTranslation('back_to_projects', 'Back to Projects', 'العودة إلى المشاريع');
        $this->createTranslation('error_occurred', 'There were some problems with your input:', 'حدثت بعض المشاكل في المدخلات:');

        // Email Form
        $this->createTranslation('send_email', 'Send Email', 'إرسال بريد إلكتروني');
        $this->createTranslation('email_to', 'Email To', 'البريد الإلكتروني إلى');
        $this->createTranslation('subject', 'Subject', 'الموضوع');
        $this->createTranslation('message', 'Message', 'الرسالة');
        $this->createTranslation('initial_project_files', 'Initial Project Files', 'ملفات المشروع الأولية');
        $this->createTranslation('download', 'Download', 'تحميل');
        $this->createTranslation('attach_to_email', 'Attach to email', 'إرفاق في البريد');
        $this->createTranslation('additional_attachments', 'Additional Attachments', 'المرفقات الإضافية');
        $this->createTranslation('multiple_files_info', 'You can select multiple files', 'يمكنك اختيار عدة ملفات');
        $this->createTranslation('project_update', 'Project Update', 'تحديث المشروع');
        $this->createTranslation('email_template', 'Dear {name},
I hope you\'re doing well. I wanted to provide an update on {project_name} and share the latest files.
Please find attached the relevant project documents.
Best regards,
{user_name}', 'عزيزي {name},
أتمنى أن تكون بخير. أريد أن أقدم لك تحديثاً حول {project_name} ومشاركة أحدث الملفات.
يمكنك العثور على الوثائق ذات الصلة المرفقة.
مع التحية,
{user_name}');
    }

    private function createTranslation($key, $valueEn, $valueAr, $group = 'projects')
    {
        // Check if translation already exists
        $existingTranslation = Translation::where('key', $key)->first();
        
        if ($existingTranslation) {
            // Update existing translation
            $existingTranslation->update([
                'value_en' => $valueEn,
                'value_ar' => $valueAr,
                'group' => $group,
                'is_active' => true
            ]);
        } else {
            // Create new translation
            Translation::create([
                'key' => $key,
                'value_en' => $valueEn,
                'value_ar' => $valueAr,
                'group' => $group,
                'is_active' => true
            ]);
        }
    }
}
