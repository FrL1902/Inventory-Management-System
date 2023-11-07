<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_permissions')->insert([[
            'name' => 'user1',
            'page' => 'tambah_customer_baru',
            'status' => '1',
        ], [
            'name' => 'user1',
            'page' => 'data_customer',
            'status' => '1',
        ], [
            'name' => 'user1',
            'page' => 'tambah_brand_baru',
            'status' => '1',
        ], [
            'name' => 'user1',
            'page' => 'data_brand',
            'status' => '1',
        ], [
            'name' => 'user1',
            'page' => 'laporan_stok_by_pcs',
            'status' => '1',
        ], [
            'name' => 'user1',
            'page' => 'tambah_barang_baru',
            'status' => '1',
        ], [
            'name' => 'user1',
            'page' => 'data_barang',
            'status' => '1',
        ], [
            'name' => 'user1',
            'page' => 'barang_datang',
            'status' => '1',
        ], [
            'name' => 'user1',
            'page' => 'barang_keluar',
            'status' => '1',
        ], [
            'name' => 'user1',
            'page' => 'history_stok_by_pcs',
            'status' => '1',
        ], [
            'name' => 'user1',
            'page' => 'laporan_stok_by_palet',
            'status' => '1',
        ], [
            'name' => 'user1',
            'page' => 'palet_masuk',
            'status' => '1',
        ], [
            'name' => 'user1',
            'page' => 'palet_keluar',
            'status' => '1',
        ], [
            'name' => 'user1',
            'page' => 'history_stok_by_palet',
            'status' => '1',
        ], [ //ini batas buat misahin kargo sama gudang td
            'name' => 'user2',
            'page' => 'tambah_customer_baru',
            'status' => '1',
        ], [
            'name' => 'user2',
            'page' => 'data_customer',
            'status' => '1',
        ], [
            'name' => 'user2',
            'page' => 'tambah_brand_baru',
            'status' => '1',
        ], [
            'name' => 'user2',
            'page' => 'data_brand',
            'status' => '1',
        ], [
            'name' => 'user2',
            'page' => 'laporan_stok_by_pcs',
            'status' => '1',
        ], [
            'name' => 'user2',
            'page' => 'tambah_barang_baru',
            'status' => '1',
        ], [
            'name' => 'user2',
            'page' => 'data_barang',
            'status' => '1',
        ], [
            'name' => 'user2',
            'page' => 'barang_datang',
            'status' => '1',
        ], [
            'name' => 'user2',
            'page' => 'barang_keluar',
            'status' => '1',
        ], [
            'name' => 'user2',
            'page' => 'history_stok_by_pcs',
            'status' => '1',
        ], [
            'name' => 'user2',
            'page' => 'laporan_stok_by_palet',
            'status' => '1',
        ], [
            'name' => 'user2',
            'page' => 'palet_masuk',
            'status' => '1',
        ], [
            'name' => 'user2',
            'page' => 'palet_keluar',
            'status' => '1',
        ], [
            'name' => 'user2',
            'page' => 'history_stok_by_palet',
            'status' => '1',
        ]]);
    }
}
