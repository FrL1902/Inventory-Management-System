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

        DB::table('users')->insert([
            'name' => 'gudang',
            'email' => 'gudang@gmail.com',
            'password' => Hash::make('gudang'),
            'level' => 'gudang',
            'pass' => 'gudang',
        ]);

        DB::table('users')->insert([
            'name' => 'customer',
            'email' => 'customer@gmail.com',
            'password' => Hash::make('customer'),
            'level' => 'customer',
            'pass' => 'customer',
        ]);

        DB::table('users')->insert([
            'name' => 'kargo',
            'email' => 'kargo@gmail.com',
            'password' => Hash::make('kargo'),
            'level' => 'cargo',
            'pass' => 'cargo',
        ]);
    }
}
