<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FakultasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['id' => 1, 'name' => 'Hukum', 'bidang_fakultas_id' => 2],
            ['id' => 2, 'name' => 'Pertanian', 'bidang_fakultas_id' => 1],
            ['id' => 3, 'name' => 'Kedokteran', 'bidang_fakultas_id' => 1],
            ['id' => 4, 'name' => 'Matematika dan Ilmu Pengetahuan Alam', 'bidang_fakultas_id' => 1],
            ['id' => 5, 'name' => 'Ekonomi dan Bisnis', 'bidang_fakultas_id' => 2],
            ['id' => 6, 'name' => 'Peternakan', 'bidang_fakultas_id' => 1],
            ['id' => 7, 'name' => 'Ilmu Budaya', 'bidang_fakultas_id' => 2],
            ['id' => 8, 'name' => 'Ilmu Sosial dan Ilmu Politik', 'bidang_fakultas_id' => 2],
            ['id' => 9, 'name' => 'Teknik', 'bidang_fakultas_id' => 1],
            ['id' => 10, 'name' => 'Farmasi', 'bidang_fakultas_id' => 1],
            ['id' => 11, 'name' => 'Teknologi Pertanian', 'bidang_fakultas_id' => 1],
            ['id' => 12, 'name' => 'Kesehatan Masyarakat', 'bidang_fakultas_id' => 1],
            ['id' => 13, 'name' => 'Keperawatan', 'bidang_fakultas_id' => 1],
            ['id' => 14, 'name' => 'Kedokteran Gigi', 'bidang_fakultas_id' => 1],
            ['id' => 15, 'name' => 'Teknologi Informasi', 'bidang_fakultas_id' => 1],
        ];
        DB::table('fakultas')->updateOrInsert($data);
    }
}
