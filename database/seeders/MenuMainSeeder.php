<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
                'id' => 'ini-id-menu-main-1',
                'menu' => 'ini-id-menu-1',
                'judul' => 'Jabatan Judul',
                'icon' => 'data-jabatan'
            ],
            [
                'id' => 'ini-id-menu-main-2',
                'menu' => 'ini-id-menu-2',
                'judul' => 'Grade Judul',
                'icon' => 'data-grade'
            ],
        ]);
    }
}
