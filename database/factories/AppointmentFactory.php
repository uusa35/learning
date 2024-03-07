<?php

namespace Database\Factories;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date' => fake()->dateTimeBetween('+1 day', '+1 month'),
            'start' => Carbon::parse(fake()->dateTimeBetween('now', '+1 minutes'))->format('H:i:s'),
            'end' => Carbon::parse(fake()->dateTimeBetween('now', '+20 minutes'))->format('H:i:s'),
            'patient_id' => User::role('patient')->get()->random()->id,
            'doctor_id' => User::role('doctor')->get()->random()->id,
            'creator_id' => User::role('receptionist')->get()->random()->id,
            'status' => fake()->randomElement(['pending', 'canceled', 'complete']),
            'notes' => fake()->paragraph(1)
        ];
    }
}
