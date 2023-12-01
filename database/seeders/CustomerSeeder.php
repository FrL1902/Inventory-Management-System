<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('customer')->insert([[
        //     'customer_id' => 'CU001',
        //     'customer_name' => 'inem',
        //     'address' => 'jatiwarna',
        //     'email' => 'inemIndustry@inem.com',
        //     'phone1' => '+6287489',
        //     'phone2' => '0218541732',
        //     'fax' => '(0542)4567980',
        //     'website' => 'inemlogistics.com',
        //     'pic' => 'inem',
        //     'pic_phone' => '081111111112',
        //     'npwp_perusahaan' => '08.178.554.2-123.321',
        // ], [
        //     'customer_id' => 'CU002',
        //     'customer_name' => 'mari',
        //     'address' => 'gamprit',
        //     'email' => 'entre@xyz.com',
        //     'phone1' => '12321489',
        //     'phone2' => '32141415',
        //     'fax' => '(0212)4567980',
        //     'website' => 'entre.com',
        //     'pic' => 'anit',
        //     'pic_phone' => '081111111113',
        //     'npwp_perusahaan' => '10.178.554.2-123.321',
        // ], [
        //     'customer_id' => 'CU003',
        //     'customer_name' => 'joel',
        //     'address' => 'morio',
        //     'email' => 'joel@gmail.com',
        //     'phone1' => '+6281239',
        //     'phone2' => '1241332',
        //     'fax' => '(021)4567980',
        //     'website' => 'morio.com',
        //     'pic' => 'tual',
        //     'pic_phone' => '081111111113',
        //     'npwp_perusahaan' => '11.178.554.2-123.321',
        // ]]);
    }
}
