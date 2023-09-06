<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pallet extends Model
{
    use HasFactory;

    protected $table = 'pallets';
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}
