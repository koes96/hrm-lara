<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //\App\Models\User::factory(15)->create();
        DB::table('users')->insert([
            [
                'id' => Str::uuid(),
                'role_id' => '2',
                'email' => 'admin2@gmail.com',
                'password' => Hash::make('admin1234'),
                'name' => 'admin1234'
            ]
        ]);
    }
}
