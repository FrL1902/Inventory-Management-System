<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $table = "brand";

    public function user(){
        return $this->belongsTo(User::class, 'customer_id', 'id');
    }
}
