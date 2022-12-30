<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Role extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert(config('constants.roles.superadmin'));
        DB::table('roles')->insert(config('constants.roles.client'));
        DB::table('roles')->insert(config('constants.roles.visitor'));
    }
}
