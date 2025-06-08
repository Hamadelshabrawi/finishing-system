<?php

namespace Database\Factories;

use App\Models\Material;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Material>
 */
class MaterialFactory extends Factory
{
    protected $model = Material::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'project_id' => \App\Models\Project::factory(),
            'item_id' => \App\Models\Item::factory(),
            'quantity' => $this->faker->numberBetween(1, 100),
            'notes' => $this->faker->sentence,
            'source' => $this->faker->randomElement([
                Material::SOURCE_INVENTORY,
                Material::SOURCE_MANUAL
            ]),
            'approval_status' => Material::APPROVAL_PENDING,
        ];
    }
}
