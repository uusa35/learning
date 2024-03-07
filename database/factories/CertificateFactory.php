<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Certificate>
 */
class CertificateFactory extends Factory
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
            'name_en' => fake()->name(),
            'name_ar' => 'اسم ' . $fakerAr->firstName,
            'description_ar' => $fakerAr->sentence(2),
            'description_en' => fake()->sentence(2),
            'type' => fake()->randomElement(['certificate', 'award']),
            'user_id' => User::role('doctor')->get()->random()->id
        ];
    }
}
