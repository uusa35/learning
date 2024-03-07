<?php

namespace Database\Seeders;

use App\Models\Medicine;
use App\Models\Prescription;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PrescriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Prescription::factory(app()->environment("production") ? 2 : 4)->create()->each(function ($p) {
            return $p->medicines()->saveMany(Medicine::factory(3)->create());
        });
    }
}
