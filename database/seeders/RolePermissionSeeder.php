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
        'view projects',
        'view projects clients',
        'edit projects',
        'create projects',
        'delete projects',
        'view clients',
        'edit clients',
        'create clients',
        'delete clients',
        'delete clients',
    ];

    foreach ($permissions as $permission) {
        Permission::firstOrCreate(['name' => $permission]);
    }

    $admin = Role::firstOrCreate(['name' => 'Admin']);
    $editor = Role::firstOrCreate(['name' => 'Technical']);
    $viewer = Role::firstOrCreate(['name' => 'Financial']);
    $viewer = Role::firstOrCreate(['name' => 'Operations Manager']);
    $viewer = Role::firstOrCreate(['name' => 'Storekeeper']);
    $viewer = Role::firstOrCreate(['name' => 'User']);

    $admin->givePermissionTo(Permission::all());
    $editor->givePermissionTo(['view projects', 'edit projects', 'create projects']);
    $viewer->givePermissionTo(['view projects']);
}

}
