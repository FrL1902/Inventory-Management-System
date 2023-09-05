<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PalletController extends Controller
{
    public function manage_pallet_page(){
        return view('managePallet');
    }

    public function manage_pallet_history_page(){
        return view('palletHistory');
    }
}
