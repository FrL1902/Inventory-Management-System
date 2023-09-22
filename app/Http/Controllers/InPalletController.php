<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InPalletController extends Controller
{
    //
    public function in_pallet_page(){
        return view('inPallet');
    }
}
