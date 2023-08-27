<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BidangFakultasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['id' => 1, 'name' => 'Saintek'],
            ['id' => 2, 'name' => 'Soshum'],
        ];
        DB::table('bidang_fakultas')->insert($data);
    }
}
