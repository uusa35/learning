<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
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
            'name_ar' => 'تصنيف ' . $fakerAr->firstName,
            'name_en' => 'category ' . $this->faker->firstName,
            'order' => $this->faker->numberBetween(1, 99),
            'image' => 'square.png',
            'parent_id' => Category::where('parent_id', 0)->pluck('id')->shuffle()->first(),
        ];
    }
}
