<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class MenuMainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menu_mains')->insert([
            [
                'id' => Str::uuid(),
                'menu' => 'Admin',
                'judul' => 'admin',
                'icon' => 'admin'
            ],
            [
                'id' => Str::uuid(),
                'menu' => 'Pegawai',
                'judul' => 'pegawai',
                'icon' => 'pegawai'
            ],
        ]);
    }
}
