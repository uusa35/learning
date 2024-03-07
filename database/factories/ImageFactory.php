<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
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
            "imagable_id" => $this->faker->numberBetween(1, 60),
            "imagable_type" => $this->faker->randomElement([
                "App\Models\User"
            ]),
        ];
    }
}
