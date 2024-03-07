<?php

namespace Database\Seeders;

use App\Models\Day;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use phpDocumentor\Reflection\PseudoTypes\LowercaseString;

class DaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i < 7; $i++) {
            Day::factory()->create([
                'name' => strtolower(Carbon::now()->subDays($i)->format('l')),
                'name_en' => strtolower(Carbon::now()->subDays($i)->format('l')),
                'name_ar' => strtolower(Carbon::now()->locale('ar')->subDays($i)->format('l')),
            ]);
        }
    }
}
