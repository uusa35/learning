<?php

namespace Database\Factories;

use App\Models\Day;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Slot>
 */
class SlotFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'start' => Carbon::parse(fake()->dateTimeBetween('now', '+1 minutes'))->format('H:i:s'),
            'end' => Carbon::parse(fake()->dateTimeBetween('now', '+20 minutes'))->format('H:i:s'),
            'day_id' => Day::all()->random()->id,
            'doctor_id' => User::role('doctor')->get()->random()->id
        ];
    }
}
