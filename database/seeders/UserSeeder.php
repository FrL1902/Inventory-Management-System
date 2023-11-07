<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
            'level' => 'admin',
            'pass' => 'admin',
        ]);

        DB::table('users')->insert([[
            'name' => 'user1',
            'email' => 'user1@gmail.com',
            'password' => Hash::make('user1'),
            'level' => 'user',
            'pass' => 'user1',
        ],[
            'name' => 'user2',
            'email' => 'user2@gmail.com',
            'password' => Hash::make('user2'),
            'level' => 'user',
            'pass' => 'user2',
        ]]);

        // DB::table('users')->insert([
        //     'name' => 'customer',
        //     'email' => 'customer@gmail.com',
        //     'password' => Hash::make('customer'),
        //     'level' => 'customer',
        //     'pass' => 'customer',
        // ]);

        // DB::table('users')->insert([
        //     'name' => 'kargo',
        //     'email' => 'kargo@gmail.com',
        //     'password' => Hash::make('kargo'),
        //     'level' => 'cargo',
        //     'pass' => 'cargo',
        // ]);
    }
}
