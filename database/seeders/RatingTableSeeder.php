<?php

namespace Database\Seeders;

use App\Models\Rating;
use App\Models\User;
use App\Models\Vendor;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RatingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Rating::factory(5000)->create()->each(function($rating){
            $user = User::inRandomOrder()->first();
            $vendor = Vendor::inRandomOrder()->first();
            $faker = Factory::create();
            $rating->vendor_id = $vendor->id;
            $rating->user_id = $user->id;
            $rating->comments = $faker->text(200) ;
            $rating->rating = $faker->randomFloat(1, 0, 5);
            $rating->save();
        });
    }
}
