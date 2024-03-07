<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "total" => $this->faker->randomFloat(3, 22, 200),
            "discount" => $this->faker->randomFloat(3, 10, 22), // discount will be updated if there is a coupon applied.
            "net_total" => function ($array) {
                return $array["total"] - $array["discount"];
            },
            "reference_id" => $this->faker->numberBetween([11111, 9999999]),
            "appointment_id" => Appointment::all()->random()->id,
            "creator_id" => User::role("receptionist")->get()->random()->id,
            "status" => $this->faker->randomElement(["pending", "paid", "completed", 'canceled']),
            "paid" => $this->faker->boolean()
        ];
    }
}
