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

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed roles and permissions
        $this->call([
            RolesAndPermissionsSeeder::class,
            SupplierPermissionSeeder::class
        ]);
        
        // Create admin user if it doesn't exist
        $adminUser = \App\Models\User::where('email', 'admin@example.com')->first();
        if (!$adminUser) {
            $adminUser = \App\Models\User::create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'user_type' => 'Admin'
            ]);
            $adminUser->assignRole('Admin');
        }

        // Create clients first
        $clients = \App\Models\Client::factory()->count(5)->create();
        
        // Create materials
        $materials = \App\Models\Material::factory()->count(10)->create();
        
        // Create final finishes
        $finalFinishes = \App\Models\FinalFinish::factory()->count(10)->create();
        
        // Create items
        $items = \App\Models\Item::factory()->count(25)->create();
        
        // Create projects with proper relationships
        $projects = \App\Models\Project::factory()
            ->count(5)
            ->create()
            ->each(function ($project) use ($clients, $adminUser) {
                $project->client_id = $clients->random()->id;
                $project->created_by = $adminUser->id;
                $project->save();
            });
        
        // Create item purchases
        \App\Models\ItemPurchase::factory()
            ->count(10)
            ->make()
            ->each(function ($purchase) use ($items) {
                $purchase->item_id = $items->random()->id;
                $purchase->save();
            });
        
        // Create jobs
        \App\Models\Job::factory()
            ->count(10)
            ->make()
            ->each(function ($job) use ($projects) {
                $job->project_id = $projects->random()->id;
                $job->save();
            });
        
        // Create outsources
        \App\Models\Outsource::factory()
            ->count(10)
            ->make()
            ->each(function ($outsource) use ($projects) {
                $outsource->project_id = $projects->random()->id;
                $outsource->save();
            });
        \App\Models\Product::factory()->count(10)->create();

        // Seed translations after basic models are created
        $this->call([
            ProjectTranslationsSeeder::class
        ]);

        // Create additional clients and projects with products
        \App\Models\Client::factory(5)->create();
        \Database\Factories\ProjectFactory::new()->count(5)
            ->has(
                \App\Models\Product::factory(3)
            )
            ->create();
    }
}
