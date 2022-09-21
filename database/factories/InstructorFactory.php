<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\instructor>
 */
class InstructorFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition() {
        //CREATE 100 INSTRUCTORS
        return [
            'dni' => $this->faker->ean8(),
            'name' => $this->faker->name(),
            'area' => $this->faker->catchPhrase(),
        ];
    }
}
