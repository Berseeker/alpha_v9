<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

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
            'name' => 'Admin',
            'email' => "admin@admin.com",
            'password' => Hash::make('harimakenji01'),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            'name' => 'JuanPi',
            'email' => "juan.alucard.02@gmail.com",
            'password' => Hash::make('harimakenji01'),       
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
