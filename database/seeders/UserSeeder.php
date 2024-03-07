<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\Certificate;
use App\Models\Image;
use App\Models\Order;
use App\Models\Slot;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = collect(['super', 'admin', 'doctor', 'patient', 'receptionist']);
        $i = 0;

        $users->each(function ($user) {
            User::factory()->create(['name' => $user, 'email' => $user . '@example.com'])->each(function ($p) use ($user) {

                if ($user === 'admin') {
                    $p->assignRole('admin', 'doctor', 'patient', 'receptionist');
                    $p->images()->saveMany(Image::factory(4)->create());
                }
                if ($user === 'super') {
                    $p->assignRole('super', 'admin', 'doctor', 'patient', 'receptionist');
                }
            });
        });

        // doctors / patients

        $users->each(function ($user) {
            User::factory(4)->create()->each(function ($p) use ($user) {

                if ($user === 'doctor') {
                    $p->assignRole($user);
                    $p->update(['email' => $user . $p->id . '@example.com']);
                    $p->categories()->saveMany(Category::all()->random(2));
                    $p->tags()->saveMany(Tag::all()->random(2));
                    $p->certificates()->saveMany(Certificate::factory(2)->create());
                    // $p->doctor_appointments()->saveMany(Appointment::factory(2)->create());
                    $p->slots()->saveMany(Slot::factory(6)->create());
                }
                if ($user === 'patient') {
                    $p->assignRole($user);
                    $p->update(['email' => $user . $p->id . '@example.com']);
                    $p->categories()->saveMany(Category::all()->random(2));
                    $p->tags()->saveMany(Tag::all()->random(2));
                    DB::table('user_attribute')->insert([
                        'attribute_id' => Attribute::all()->random()->id,
                        'user_id' => $p->id,
                        'value' => fake()->numberBetween(10, 99),
                    ]);
                }
                if ($user === 'receptionist') {
                    $p->assignRole($user);
                    $p->update(['email' => $user . $p->id . '@example.com']);
                    $p->categories()->saveMany(Category::onlyParent()->get()->random(2));
                }
            });
        });
    }
}
