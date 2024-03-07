<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(SettingSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(TagSeeder::class);
        $this->call(MedicineSeeder::class);
        $this->call(AttributeSeeder::class);
        $this->call(CouponSeeder::class);
        $this->call(DaySeeder::class);

        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(AppointmentSeeder::class);
        $this->call(PrescriptionSeeder::class);
    }
}
