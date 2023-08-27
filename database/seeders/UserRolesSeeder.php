<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['id' => 1, 'name' => 'Admin'],
            ['id' => 2, 'name' => 'Panitia'],
            ['id' => 3, 'name' => 'Penilai'],
            ['id' => 4, 'name' => 'User'],
        ];

        DB::table('user_roles')->insertOrIgnore($data);
    }
}
