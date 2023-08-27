<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Rafi Maryudwika',
            'email' => 'rafi.maryudwika.14@gmail.com',
            'email_verified_at' => null,
            'no_hp' => '0812123456',
            'password' => bcrypt('adminITU2023'),
            'role' => 1,
            'peserta' => false,
        ]);
    }
}
