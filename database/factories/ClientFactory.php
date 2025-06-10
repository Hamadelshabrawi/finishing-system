<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    protected $model = Client::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Create admin role if it doesn't exist
        \Spatie\Permission\Models\Role::firstOrCreate([
            'name' => 'Admin'
        ]);
        
        // Create admin user if it doesn't exist
        $admin = \App\Models\User::where('email', 'admin@admin.com')->first();
        if (!$admin) {
            $admin = \App\Models\User::create([
                'name' => 'Admin User',
                'email' => 'admin@admin.com',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'user_type' => 'Admin'
            ]);
            $admin->assignRole('Admin');
        }
        return [
            'name' => $this->faker->company,
            'email' => $this->faker->companyEmail,
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'created_by' => $admin->id,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
