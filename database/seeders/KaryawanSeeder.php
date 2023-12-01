<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class KaryawanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('karyawans')->insert([
            'nik' => '0001',
            'nama' => 'abd',
            'jabatan' => 'PJ',
            'no_hp' => '081912475382',
            'foto' => '0',
            'kode_dpt' => 'DWK001',
            'password' => Hash::make('coba'),
        ]);
    }
}
