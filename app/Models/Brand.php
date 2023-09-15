<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $table = "brand";

    protected $primaryKey = 'brand_id';
    public $incrementing = false;
    protected $keyType = 'string';

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function item()
    {
        return $this->hasMany(Item::class, 'brand_id');
    }

    public static function tes(){
        return "hellow";
    }

    public static function checkNullBrandCustomer($id){

        $nullCheckBrand = Brand::where('customer_id', $id)->first();
        // dd('masok cok');
        // dd(is_null($tes));
        if (is_null($nullCheckBrand)) {
            return "kosong";
        } else {
            return "ada";
        }
    }

}
