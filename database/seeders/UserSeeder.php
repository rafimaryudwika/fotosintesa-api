<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
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
        User::insert([
            'id' => Str::ulid(),
            'name' => 'Rafi Maryudwika',
            'email' => 'rafi.maryudwika.14@gmail.com',
            'email_verified_at' => null,
            'no_hp' => '+62812123456',
            'password' => bcrypt('adminITU2023'),
            'role' => 1,
            'peserta' => false,
        ]);
    }
}
