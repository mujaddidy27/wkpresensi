<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IzinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('izins')->insert([
            'nik' => '0001',
            'tgl_izin' => '2023-09-10',
            'status_izin' => '2023-09-10',
            'keterangan_izin' => '2023-09-10',
            'status' => 'PJ',
            'foto' => '081912475382',

        ]);
    }
}
