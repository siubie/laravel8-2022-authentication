<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Fcades\DB;
use Illuminate\Support\Fcades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Administrator',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
        ]);
    }
}
