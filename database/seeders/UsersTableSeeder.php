<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Image;
use App\Models\Order;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = ['super', 'admin', 'doctor', 'patient', 'receptionist'];
        $i = 0;
        foreach ($users as $user) {
            User::factory($user === 'doctor' ? 10 : 1)->create(['username' => $user])->each(function ($p) use ($user) {
                if ($user === 'doctor') {
                    $p->update(['email' => $user . $p->id . '@example.com']);
                } else {
                    $p->update(['email' => $user . '@example.com']);
                }
                $p->assignRole($p->username);
                if ($p->username === 'doctor') {
                    $p->categories()->saveMany(Category::onlyParent()->get()->random(2));
                    $p->tags()->saveMany(Tag::factory(2)->create());
                    $p->orders()->saveMany(Order::factory(2)->create(['user_id' => $p->id]));
                }
                if ($p->username === 'pateint') {
                    $p->categories()->saveMany(Category::onlyParent()->get()->random(2));
                    $p->tags()->saveMany(Tag::factory(2)->create());
                }
                if ($p->username === 'receptionist') {
                    $p->categories()->saveMany(Category::onlyParent()->get()->random(2));
                    $p->tags()->saveMany(Tag::factory(2)->create());
                }

                if ($p->username === 'admin') {
                    $p->images()->saveMany(Image::factory(4)->create(['on_home' => 1]));
                }
                if ($p->username === 'Super') {
                }
            });
        }
    }
}
