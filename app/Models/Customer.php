<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customer';
    protected $fillable = [
        'customer_id',
        'customer_name',
        'address',
        'email',
        'phone1',
        'phone2',
        'fax',
        'website',
        'pic',
        'pic_phone',
        'npwp_perusahaan',
    ];

    public function brand()
    {
        return $this->hasMany(Brand::class, 'customer_id', 'id');
    }
}
