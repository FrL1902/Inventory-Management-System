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

    public static function checkPageStatus($name, $page){

        $userLevel = User::where('name', $name)->first(); //21-24 ini belum tentu bisa
        if($userLevel->level == 'admin'){
            return 1;
        }

        $pageStatus = UserPermission::where('name', $name)->where('page', $page)->first();
        // dd($pageStatus);
        // dd(is_null($tes));
        if ($pageStatus->status == 1) {
            return 1;
        } else {
            return 0;
        }
    }
}
