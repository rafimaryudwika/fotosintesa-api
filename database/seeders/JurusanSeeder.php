<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['id' => 11, 'name' => 'Ilmu Hukum', 'fakultas_id' => 1],
            ['id' => 21, 'name' => 'Agroteknologi','fakultas_id' => 2],
            ['id' => 22, 'name' => 'Sosial Ekonomi Pertanian','fakultas_id' => 2],
            ['id' => 23, 'name' => 'Ilmu Tanah','fakultas_id' => 2],
            ['id' => 25, 'name' => 'Proteksi Tanaman','fakultas_id' => 2],
            ['id' => 27, 'name' => 'Penyuluhan Pertanian','fakultas_id' => 2],
            ['id' => 31, 'name' => 'Kedokteran','fakultas_id' => 3],
            ['id' => 32, 'name' => 'Psikologi','fakultas_id' => 3],
            ['id' => 33, 'name' => 'Kebidanan','fakultas_id' => 3],
            ['id' => 34, 'name' => 'Ilmu Biomedis','fakultas_id' => 3],
            ['id' => 41, 'name' => 'Kimia','fakultas_id' => 4],
            ['id' => 42, 'name' => 'Biologi','fakultas_id' => 4],
            ['id' => 43, 'name' => 'Matematika','fakultas_id' => 4],
            ['id' => 44, 'name' => 'Fisika','fakultas_id' => 4],
            ['id' => 51, 'name' => 'Ilmu Ekonomi','fakultas_id' => 5],
            ['id' => 52, 'name' => 'Manajemen','fakultas_id' => 5],
            ['id' => 53, 'name' => 'Akuntansi','fakultas_id' => 5],
            ['id' => 57, 'name' => 'Ekonomi Islam','fakultas_id' => 5],
            ['id' => 510, 'name' => 'D3 Pemasaran','fakultas_id' => 5],
            ['id' => 520, 'name' => 'D3 Kesekretariatan','fakultas_id' => 5],
            ['id' => 530, 'name' => 'D3 Manajemen Perkantoran','fakultas_id' => 5],
            ['id' => 540, 'name' => 'D3 Keuangan','fakultas_id' => 5],
            ['id' => 61, 'name' => 'Peternakan','fakultas_id' => 6],
            ['id' => 71, 'name' => 'Ilmu Sejarah','fakultas_id' => 7],
            ['id' => 72, 'name' => 'Sastra Indonesia','fakultas_id' => 7],
            ['id' => 73, 'name' => 'Sastra Inggris','fakultas_id' => 7],
            ['id' => 74, 'name' => 'Sastra Minangkabau','fakultas_id' => 7],
            ['id' => 75, 'name' => 'Sastra Jepang','fakultas_id' => 7],
            ['id' => 81, 'name' => 'Sosiologi','fakultas_id' => 8],
            ['id' => 82, 'name' => 'Antropologi Sosial','fakultas_id' => 8],
            ['id' => 83, 'name' => 'Ilmu Politik','fakultas_id' => 8],
            ['id' => 84, 'name' => 'Ilmu Administrasi Negara','fakultas_id' => 8],
            ['id' => 85, 'name' => 'Ilmu Hubungan Internasional','fakultas_id' => 8],
            ['id' => 86, 'name' => 'Ilmu Komunikasi','fakultas_id' => 8],
            ['id' => 91, 'name' => 'Teknik Mesin','fakultas_id' => 9],
            ['id' => 92, 'name' => 'Teknik Sipil','fakultas_id' => 9],
            ['id' => 93, 'name' => 'Teknik Industri','fakultas_id' => 9],
            ['id' => 94, 'name' => 'Teknik Lingkungan','fakultas_id' => 9],
            ['id' => 95, 'name' => 'Teknik Elektro','fakultas_id' => 9],
            ['id' => 96, 'name' => 'Arsitektur','fakultas_id' => 9],
            ['id' => 101, 'name' => 'Farmasi','fakultas_id' => 10],
            ['id' => 111, 'name' => 'Teknik Pertanian','fakultas_id' => 11],
            ['id' => 112, 'name' => 'Teknologi Hasil Pertanian','fakultas_id' => 11],
            ['id' => 113, 'name' => 'Teknologi Industri Pertanian','fakultas_id' => 11],
            ['id' => 121, 'name' => 'Ilmu Kesehatan Masyarakat','fakultas_id' => 12],
            ['id' => 122, 'name' => 'Ilmu Gizi','fakultas_id' => 12],
            ['id' => 131, 'name' => 'Ilmu Kesehatan Masyarakat','fakultas_id' => 13],
            ['id' => 141, 'name' => 'Kedokteran Gigi','fakultas_id' => 14],
            ['id' => 151, 'name' => 'Teknik Komputer','fakultas_id' => 15],
            ['id' => 152, 'name' => 'Sistem Informasi','fakultas_id' => 15],
            ['id' => 153, 'name' => 'Informatika','fakultas_id' => 15],
        ];
        DB::table('jurusans')->insert($data);
    }
}
