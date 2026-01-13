<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class SupplierPermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            'Manage Supplier Inventory',
            'View Supplier Analytics',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
