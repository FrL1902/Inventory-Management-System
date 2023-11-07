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
            'name' => 'kargo',
            'page' => 'home',
            'status' => '1',
        ],[
            'name' => 'kargo',
            'page' => 'tambah_customer_baru',
            'status' => '1',
        ],[
            'name' => 'kargo',
            'page' => 'data_customer',
            'status' => '1',
        ],[
            'name' => 'kargo',
            'page' => 'tambah_brand_baru',
            'status' => '1',
        ],[
            'name' => 'kargo',
            'page' => 'data_brand',
            'status' => '1',
        ],[
            'name' => 'kargo',
            'page' => 'laporan_stok_by_pcs',
            'status' => '1',
        ],[
            'name' => 'kargo',
            'page' => 'tambah_barang_baru',
            'status' => '1',
        ],[
            'name' => 'kargo',
            'page' => 'data_barang',
            'status' => '1',
        ],[
            'name' => 'kargo',
            'page' => 'barang_datang',
            'status' => '1',
        ],[
            'name' => 'kargo',
            'page' => 'barang_keluar',
            'status' => '1',
        ],[
            'name' => 'kargo',
            'page' => 'history_stok_by_pcs',
            'status' => '1',
        ],[
            'name' => 'kargo',
            'page' => 'laporan_stok_by_palet',
            'status' => '1',
        ],[
            'name' => 'kargo',
            'page' => 'palet_masuk',
            'status' => '1',
        ],[
            'name' => 'kargo',
            'page' => 'palet_keluar',
            'status' => '1',
        ],[
            'name' => 'kargo',
            'page' => 'history_stok_by_palet',
            'status' => '1',
        ],[ //ini batas buat misahin kargo sama gudang
            'name' => 'gudang',
            'page' => 'home',
            'status' => '1',
        ],[
            'name' => 'gudang',
            'page' => 'tambah_customer_baru',
            'status' => '1',
        ],[
            'name' => 'gudang',
            'page' => 'data_customer',
            'status' => '1',
        ],[
            'name' => 'gudang',
            'page' => 'tambah_brand_baru',
            'status' => '1',
        ],[
            'name' => 'gudang',
            'page' => 'data_brand',
            'status' => '1',
        ],[
            'name' => 'gudang',
            'page' => 'laporan_stok_by_pcs',
            'status' => '1',
        ],[
            'name' => 'gudang',
            'page' => 'tambah_barang_baru',
            'status' => '1',
        ],[
            'name' => 'gudang',
            'page' => 'data_barang',
            'status' => '1',
        ],[
            'name' => 'gudang',
            'page' => 'barang_datang',
            'status' => '1',
        ],[
            'name' => 'gudang',
            'page' => 'barang_keluar',
            'status' => '1',
        ],[
            'name' => 'gudang',
            'page' => 'history_stok_by_pcs',
            'status' => '1',
        ],[
            'name' => 'gudang',
            'page' => 'laporan_stok_by_palet',
            'status' => '1',
        ],[
            'name' => 'gudang',
            'page' => 'palet_masuk',
            'status' => '1',
        ],[
            'name' => 'gudang',
            'page' => 'palet_keluar',
            'status' => '1',
        ],[
            'name' => 'gudang',
            'page' => 'history_stok_by_palet',
            'status' => '1',
        ]]);

    }
}
