<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(15)->create();
        // DB::table('users')->insert([
        //     [
        //         'id' => 'ini-id-admin-1',
        //         'role_id' => '2',
        //         'email' => 'admin@gmail.com',
        //         'password' => Hash::make('password'),
        //         'name' => 'admin1234'
        //     ]
        // ]);
    }
}
