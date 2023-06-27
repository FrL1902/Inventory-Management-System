<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $table = 'items';

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function incoming()
    {
        return $this->hasMany(Incoming::class, 'item_id');
    }

    public function outgoing()
    {
        return $this->hasMany(Outgoing::class, 'item_id');
    }

    public static function checkNullItemBrand($id){
        $nullCheckItem = Item::where('brand_id', $id)->first();
            if (is_null($nullCheckItem)) {
                return "kosong";
            } else {
                return "ada";
            }
    }

}
