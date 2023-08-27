<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolePanitiaSeeder extends Seeder
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
    }
}
