<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fakerAr = \Faker\Factory::create('ar_JO');
        return [
            'name' => fake()->name(),
            'name_en' => fake()->name(),
            'name_ar' => 'اسم ' . $fakerAr->firstName,
            'title_en' => fake()->jobTitle(),
            'title_ar' => 'وظيفة ' . $fakerAr->jobTitle(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'mobile' => fake()->numberBetween(11111111, 999999999),
            'civil_id' => fake()->numberBetween(657888887676, 987675645647656),
            'nationality' => fake()->country(),
            'dob' => fake()->dateTimeBetween('-20 years'),
            'appointment_fees' => fake()->randomDigit(2),
            'notes' => fake()->sentence(),
            'description_ar' => $fakerAr->sentence(2),
            'description_en' => fake()->sentence(2),
            'signature' => fake()->randomElement(['square.png', null]),
            'blood' => fake()->randomElement(['A', 'B', 'A+', 'A-', 'AB', 'O-', 'O+', 'B+', 'B-', 'AB+', 'AB-']),
            "api_token" => hash('sha256', Str::random(60)),

        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
