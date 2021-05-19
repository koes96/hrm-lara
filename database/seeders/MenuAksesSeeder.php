<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuAksesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menu_akses')->insert([
            [
                'id' => 'ini-id-menu-akses-1',
                'role_id' => '2',
                'menu_id' => 'ini-id-menu-main-1'
            ],
            [
                'id' => 'ini-id-menu-akses-2',
                'role_id' => '2',
                'menu_id' => 'ini-id-menu-main-1',
            ],
        ]);
    }
}
