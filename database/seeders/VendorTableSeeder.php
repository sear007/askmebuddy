<?php

namespace Database\Seeders;

use App\Models\Superadmin\Category;
use App\Models\Superadmin\Service;
use App\Models\User;
use App\Models\Vendor;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VendorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::get();
        $faker = Factory::create();
        foreach ($users as $key => $user) {
            $category = Category::inRandomOrder()->first();
            $service = Service::inRandomOrder()->first();
            $vendor = Vendor::create([
                'user_id' => $user['id'],
                'service_id' => $service['id'],
                'category_id' => $category['id'],
                'business_name' => $faker->company(),
                'legal_business_name' => $faker->catchPhrase(),
            ]);
            $vendor->contact()->updateOrCreate([
                'vendor_id' => $vendor->id,
            ], [
                'contact_person' => $faker->name(),
                'mobile_no' => $faker->e164PhoneNumber(),
                'email' => $faker->companyEmail(),
            ]);
            $vendor->payment()->updateOrCreate([
                'vendor_id' => $vendor->id,
            ], [
                'cash' => $faker->boolean(50),
                'debit_card' => $faker->boolean(50),
                'credit_card' => $faker->boolean(50),
                'american_express_card' => $faker->boolean(50),
            ]);
        }
    }
}
