<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory(500)->create()->each(function($user){
            $faker = Factory::create();
            $user->name = $faker->name();
            $user->email = $faker->companyEmail();
            $user->phone = $faker->e164PhoneNumber();
            $user->provider = 'direct';
            $user->save();
            $user->roles()->attach(2);
        });
    }
}
