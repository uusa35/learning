<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tag>
 */
class TagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fakerAr = \Faker\Factory::create('ar_JO');
        return [
            'name' => $this->faker->word,
            'name_ar' => $fakerAr->word,
            'name_en' => $this->faker->word,
            'order' => $this->faker->numberBetween(1, 59),
            'image' => 'square.png',
            'active' => false
        ];
    }
}
