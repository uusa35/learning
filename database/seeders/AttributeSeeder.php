<?php

namespace Database\Seeders;

use App\Models\Attribute;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $attributes = collect(['height', 'weight', 'pressure', 'pulse', 'respiration', 'allergy', 'diet']);
        $attributes->each(
            fn ($a) =>
            Attribute::factory()->create([
                'name_ar' => $a,
                'name_en' => $a,
            ])
        );
    }
}
