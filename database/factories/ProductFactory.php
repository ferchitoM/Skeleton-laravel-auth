<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition() {
        $images = [null];

        for ($i = 1; $i <= 18; $i++) {
            array_push($images, 'gamer' . $i . '.jpg');
        }

        return [
            'name' => $this->faker->name(),
            'price' => $this->faker->numberBetween(10000, 1000000),
            'stock' => $this->faker->numberBetween(0, 100),
            'image' => $images[$this->faker->numberBetween(0, 18)],
            'top' => $this->faker->boolean(50),
            'code' => $this->faker->numberBetween(9999, 99999),
        ];
    }
}
