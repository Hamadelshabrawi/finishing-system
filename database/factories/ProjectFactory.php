<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    protected $model = Project::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'project_name' => $this->faker->sentence(3),
            'contact_value' => $this->faker->numberBetween(1, 100),
            'execution_period' => $this->faker->numberBetween(1, 12),
            'delivery_date' => $this->faker->dateTimeBetween('now', '+6 months'),
            'delivery_location' => $this->faker->address,
            'client_id' => \Database\Factories\ClientFactory::new()->create()->id,
            'description' => $this->faker->paragraph,
            'technical_approval' => $this->faker->randomElement(['pending', 'approved', 'need_modify', 'dismissed']),
            'created_by' => \App\Models\User::where('email', 'admin@example.com')->firstOrFail()->id,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
