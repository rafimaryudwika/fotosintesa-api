<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TahapPenilaianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['nomor' => 1, 'periode' => '2022', 'name' => 'Pembukaan', 'singkatan' => 'PB', 'snakecase_name' => 'pembukaan'],
            ['nomor' => 2, 'periode' => '2022', 'name' => 'Internship', 'singkatan' => 'ITR', 'snakecase_name' => 'internship'],
            ['nomor' => 3, 'periode' => '2022', 'name' => 'Final Course', 'singkatan' => 'FC', 'snakecase_name' => 'final_course'],
        ];

        DB::table('tahap_penilaians')->insertOrIgnore($data);
    }
}
