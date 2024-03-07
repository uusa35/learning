<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Medicine;
use App\Models\Order;
use App\Models\Prescription;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Appointment::factory(app()->environment("production") ? 2 : 20)->create()->each(function ($a) {
            $a->order()->save(Order::factory()->create());
            // $a->prescription()->save(
            // Prescription::factory()->create()
            // ->each(function ($p) {
            //     $p->medicines()->saveMany(Medicine::factory(2)->create());
            // })
            // );
        });
    }
}
