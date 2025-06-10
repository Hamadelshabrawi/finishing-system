<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\Product;
use App\Models\Item;
use App\Models\Client;
use App\Models\Material;
use App\Models\FinalFinish;
use App\Models\ItemPurchase;
use App\Models\Job;
use App\Models\Outsource;
use App\Models\GeneralNote;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed roles and permissions
        $this->call(RolesAndPermissionsSeeder::class);
        
        // Create admin user if it doesn't exist
        $adminUser = \App\Models\User::where('email', 'admin@admin.com')->first();
        if (!$adminUser) {
            $adminUser = \App\Models\User::create([
                'name' => 'Admin User',
                'email' => 'admin@admin.com',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'user_type' => 'Admin'
            ]);
            $adminUser->assignRole('Admin');
        }
        
        // Create items first
        \App\Models\Item::factory()->count(25)->create();
        
        // Create 5 clients
        \App\Models\Client::factory(5)->create();
        
        // Create 5 projects with 3 products each
        \Database\Factories\ProjectFactory::new()->count(5)
            ->has(
                \App\Models\Product::factory(3)
            )
            ->create();
        
        // Then create other models
        \App\Models\User::factory()->count(10)->create();
        \App\Models\Client::factory()->count(5)->create();
        \App\Models\Project::factory()->count(5)->create();
        \App\Models\Material::factory()->count(10)->create();
        \App\Models\FinalFinish::factory()->count(10)->create();
        \App\Models\ItemPurchase::factory()->count(10)->create();
        \App\Models\Job::factory()->count(10)->create();
        \App\Models\Outsource::factory()->count(10)->create();
        \App\Models\GeneralNote::factory()->count(10)->create();
        \App\Models\Product::factory()->count(10)->create();
    }
}
