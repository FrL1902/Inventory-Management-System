<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InPallet extends Model
{
    use HasFactory;
    protected $table = 'inpallet';
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}
