<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
<<<<<<< HEAD
=======
use Illuminate\Database\Eloquent\Factories\Factory;
>>>>>>> c4d717fc036442da8b3f1148ad55aa619dddf900
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
<<<<<<< HEAD
                'menu' => 'Pegawai',
                'judul' => 'pegawai',
                'icon' => 'icon'
            ],
            [
                'id' => Str::uuid(),
                'menu' => 'Admin',
                'judul' => 'admin',
                'icon' => 'icon'
=======
                'menu' => 'Admin',
                'judul' => 'admin',
                'icon' => 'admin'
            ],
            [
                'id' => Str::uuid(),
                'menu' => 'Pegawai',
                'judul' => 'pegawai',
                'icon' => 'pegawai'
>>>>>>> c4d717fc036442da8b3f1148ad55aa619dddf900
            ],
        ]);
    }
}
