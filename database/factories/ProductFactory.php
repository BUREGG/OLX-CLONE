<?php

namespace Database\Factories;

use App\Models\Category;
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
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'price' => $this->faker->numberBetween(100, 10000),
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'refresh' => $this->faker->dateTimeThisYear,
            'address' => $this->faker->word,
            'category_id' => Category::factory(),
            'user_id' => User::factory(),

        ];
    }
}
