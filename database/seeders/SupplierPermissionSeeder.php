<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class SupplierPermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            'Suppliers List',
            'Create Supplier',
            'Edit Supplier',
            'Delete Supplier',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
