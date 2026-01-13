<?php

namespace Database\Factories;

use App\Models\Outsource;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Outsource>
 */
class OutsourceFactory extends Factory
{
    protected $model = Outsource::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'project_id' => \App\Models\Project::factory(),
            'product_id' => \App\Models\Product::factory(),
            'outsource_name' => $this->faker->company,
            'boarder_note' => $this->faker->paragraph,
            'cost' => $this->faker->randomFloat(2, 100, 1000),
            'quantity' => $this->faker->numberBetween(1, 100),
        ];
    }
}
