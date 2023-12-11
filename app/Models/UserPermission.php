<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model
{
    use HasFactory;

    protected $table = "user_permissions";

    public function user()
    {
        return $this->belongsTo(User::class, 'name');
    }

    public static function checkPageStatusLayout($page)
    {

        // $userLevel = User::where('name', $name)->first();

        // check if admin
        $userInfo = auth()->user();
        if ($userInfo->level == 'admin') {
            return 1;
        }

        // dd($name. ' ' . $page);

        $pageStatus = UserPermission::where('name', $userInfo->name)->where('page', $page)->first();
        // dd(is_null($tes));
        if ($pageStatus->status == 1) {
            return 1;
        } else {
            return 0;
        }
    }

    public static function checkPageStatus($name, $page)
    {

        $userLevel = User::where('name', $name)->first();
        if ($userLevel->level == 'admin') {
            return 1;
        }

        // dd($name. ' ' . $page);
        $pageStatus = UserPermission::where('name', $name)->where('page', $page)->first();
        // dd(is_null($tes));
        if ($pageStatus->status == 1) {
            return 1;
        } else {
            return 0;
        }
    }

    public static function checkMenuCustomer()
    {
        // $userLevel = User::where('name', $name)->first();
        $userInfo = auth()->user();

        // cek kalo admin
        if ($userInfo->level == 'admin') {
            return true;
        }

        // cek kalo bukan admin
        $tambah_customer_baru = UserPermission::where('name', $userInfo->name)->where('page', 'tambah_customer_baru')->first();
        $data_customer = UserPermission::where('name', $userInfo->name)->where('page', 'data_customer')->first();

        $check = $data_customer->status + $tambah_customer_baru->status;

        if ($check == 0) {
            return false;
        } else {
            return true;
        }
    }

    public static function checkMenuBrand()
    {
        // $userLevel = User::where('name', $name)->first();
        $userInfo = auth()->user();

        // cek kalo admin
        if ($userInfo->level == 'admin') {
            return true;
        }

        // cek kalo bukan admin
        $tambah_brand_baru = UserPermission::where('name', $userInfo->name)->where('page', 'tambah_brand_baru')->first();
        $data_brand = UserPermission::where('name', $userInfo->name)->where('page', 'data_brand')->first();

        $check = $tambah_brand_baru->status + $data_brand->status;

        if ($check == 0) {
            return false;
        } else {
            return true;
        }
    }

    public static function checkMenuBarang()
    {
        // $userLevel = User::where('name', $name)->first();
        $userInfo = auth()->user();

        // cek kalo admin
        if ($userInfo->level == 'admin') {
            return true;
        }

        // cek kalo bukan admin
        $laporan_stok_by_pcs = UserPermission::where('name', $userInfo->name)->where('page', 'laporan_stok_by_pcs')->first();
        $tambah_barang_baru = UserPermission::where('name', $userInfo->name)->where('page', 'tambah_barang_baru')->first();
        $data_barang = UserPermission::where('name', $userInfo->name)->where('page', 'data_barang')->first();
        $barang_datang = UserPermission::where('name', $userInfo->name)->where('page', 'barang_datang')->first();
        $barang_keluar = UserPermission::where('name', $userInfo->name)->where('page', 'barang_keluar')->first();
        $history_stok_by_pcs = UserPermission::where('name', $userInfo->name)->where('page', 'history_stok_by_pcs')->first();


        $check = $laporan_stok_by_pcs->status +
            $tambah_barang_baru->status +
            $data_barang->status +
            $barang_datang->status +
            $barang_keluar->status +
            $history_stok_by_pcs->status;

        if ($check == 0) {
            return false;
        } else {
            return true;
        }
    }

    public static function checkMenuPalet()
    {
        // $userLevel = User::where('name', $name)->first();
        $userInfo = auth()->user();

        // cek kalo admin
        if ($userInfo->level == 'admin') {
            return true;
        }

        // cek kalo bukan admin
        $laporan_stok_by_palet = UserPermission::where('name', $userInfo->name)->where('page', 'laporan_stok_by_palet')->first();
        $palet_masuk = UserPermission::where('name', $userInfo->name)->where('page', 'palet_masuk')->first();
        $palet_keluar = UserPermission::where('name', $userInfo->name)->where('page', 'palet_keluar')->first();
        $history_stok_by_palet = UserPermission::where('name', $userInfo->name)->where('page', 'history_stok_by_palet')->first();

        $check = $laporan_stok_by_palet->status +
            $palet_masuk->status +
            $palet_keluar->status +
            $history_stok_by_palet->status;

        if ($check == 0) {
            return false;
        } else {
            return true;
        }
    }
}
