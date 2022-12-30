<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SuperAdminSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = 'Super Admin';
        $user->phone = '+855965414792';
        $user->email = 'askmebuddyofficial@gmail.com';
        $user->password = bcrypt('Askmebuddy@2022');
        $user->provider = 'direct';
        $user->isSuperAdmin = true;
        $user->save();
    }
}
