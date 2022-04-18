<?php

namespace Database\Factories;

use App\Models\BasketStatus;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Basket>
 */
class BasketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "userID" => User::factory()->create(),
            "productID" => Product::inRandomOrder()->first()->id,
            "statusID" => BasketStatus::inRandomOrder()->first()->id,
            "itemsCount" => $this->faker->randomNumber()
        ];
    }
}
