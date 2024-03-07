<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Setting>
 */
class SettingFactory extends Factory
{
    $fakerAr = \Faker\Factory::create('ar_JO');
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        'name_ar' => $fakerAr->name,
        'name_en' => $this->faker->name,
        'caption_ar' => $fakerAr->name,
        'caption_en' => $this->faker->name,
        'address_ar' => $fakerAr->address,
        'address_en' => $this->faker->name,
        'description_ar' => $fakerAr->name,
        'description_en' => $this->faker->name,
        'aboutus_ar' => $fakerAr->realText(120),
        'aboutus_en' => $this->faker->paragraph,
        'mobile' => $this->faker->bankAccountNumber,
        'whatsapp' => $this->faker->bankAccountNumber,
        'phone' => $this->faker->bankAccountNumber,
        'country_ar' => $fakerAr->country,
        'country_en' => $this->faker->country,
        'zipcode' => $this->faker->randomDigit,
        'email' => $this->faker->email,
        'android' => $this->faker->url,
        'apple' => $this->faker->url,
        'youtube' => $this->faker->url,
        'instagram' => $this->faker->url,
        'twitter' => $this->faker->url,
        'snapchat' => $this->faker->url,
        'facebook' => $this->faker->url,
        'image' => 'square.png',
        'longitude' => $this->faker->longitude,
        'latitude' => $this->faker->latitude,
        'policy_ar' => $fakerAr->realText(120),
        'policy_en' => $this->faker->paragraph,
        'terms_ar' => $fakerAr->realText(120),
        'terms_en' => $this->faker->paragraph,
        'keywords' => $this->faker->paragraph,
        ];
    }
}
