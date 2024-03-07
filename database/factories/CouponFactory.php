<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Coupon>
 */
class CouponFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => fake()->numberBetween(2222, 9999),
            'value' => fake()->randomNumber(5, 10),
            'is_percentage' => fake()->boolean(),
            'is_permanent' => fake()->boolean(),
            'consumed' => fake()->boolean(),
            'start_date' => Carbon::parse(fake()->dateTime('+1 day')),
            'end_date' => Carbon::parse(fake()->dateTime('+2 days')),
        ];
    }
}
