<?php

namespace Database\Factories;

use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    protected $model = Item::class;

    public function definition(): array
    {
        $items = [
            'Wood Panel',
            'Metal Frame',
            'Glass Sheet',
            'Leather Cover',
            'Plastic Coating',
            'Fabric',
            'Paint',
            'Glue',
            'Screws',
            'Nails',
            'Varnish',
            'Foam Padding',
            'Metal Hinges',
            'Handles',
            'Locks',
            'Rubber Feet',
            'Light Fixture',
            'Electrical Wiring',
            'Speaker System',
            'Remote Control',
            'Battery Pack',
            'USB Hub',
            'HDMI Cable',
            'Power Adapter',
            'Wall Mount',
            'Cleaning Kit',
            'Instruction Manual'
        ];

        $units = [
            'piece',
            'meter',
            'square meter',
            'set',
            'roll',
            'kilogram',
            'liter',
            'pack'
        ];

        return [
            'name' => $items[array_rand($items)],
            'unit' => $units[array_rand($units)],
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'description' => $this->faker->sentence,
        ];
    }
}
