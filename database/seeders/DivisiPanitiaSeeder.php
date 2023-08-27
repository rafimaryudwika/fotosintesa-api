<?php

namespace Database\Seeders;

use App\Models\DivisiPanitia;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DivisiPanitiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['id' => 1, 'name' => 'Inti'],
            ['id' => 2, 'name' => 'Acara'],
            ['id' => 3, 'name' => 'Perlengkapan'],
            ['id' => 4, 'name' => 'Humas'],
            ['id' => 5, 'name' => 'Pubdok'],
            ['id' => 6, 'name' => 'Konsumsi'],
        ];

        DB::table('divisi_panitias')->updateOrCreate($data);
    }
}
