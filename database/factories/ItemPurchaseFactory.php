<?php

namespace Database\Factories;

use App\Models\ItemPurchase;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ItemPurchase>
 */
class ItemPurchaseFactory extends Factory
{
    protected $model = ItemPurchase::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'item_id' => \App\Models\Item::factory(),
            'purchase_price' => $this->faker->randomFloat(2, 10, 1000),
            'quantity' => $this->faker->numberBetween(1, 100),
            'remaining_quantity' => function (array $attributes) {
                return $attributes['quantity'];
            },
            'purchase_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
