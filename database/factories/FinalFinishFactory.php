<?php

namespace Database\Factories;

use App\Models\FinalFinish;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FinalFinish>
 */
class FinalFinishFactory extends Factory
{
    protected $model = FinalFinish::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'project_id' => \App\Models\Project::factory(),
            'internal_paint' => $this->faker->boolean,
            'electrostatic' => $this->faker->boolean,
            'pvd' => $this->faker->boolean,
            'polishing' => $this->faker->boolean,
        ];
    }
}
