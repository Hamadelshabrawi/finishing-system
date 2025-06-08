<?php

namespace Database\Factories;

use App\Models\GeneralNote;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GeneralNote>
 */
class GeneralNoteFactory extends Factory
{
    protected $model = GeneralNote::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'project_id' => \App\Models\Project::factory(),
            'Note' => $this->faker->paragraph,
        ];
    }
}
