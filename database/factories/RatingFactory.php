<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rating>
 */
class RatingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $user = User::inRandomOrder()->first();
        $vendor = Vendor::inRandomOrder()->first();
        return [
            'vendor_id' => $vendor->id,
            'user_id' => $user->id,
            'comments' => fake('kh')->text(200),
            'rating' => fake('kh')->randomFloat(1, 0, 5),
        ];
    }
}