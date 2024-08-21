<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
           'name' => fake()->name(),
            'description' => fake()->paragraph(1),
            'quantity' => fake()->numberBetween(1,50),
            'status' => fake()->randomElement([Product::PRODUCTO_DISPONIBLE, Product::PRODUCTO_NO_DISPONIBLE]),
            'image' => fake()->randomElement(['1.png','2.png','3.png']),
            'seller_id' => User::inRandomOrder()->first()->id,
        ];
    }
}
