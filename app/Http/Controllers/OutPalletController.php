<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OutPalletController extends Controller
{
    //
    public function out_pallet_page()
    {
        return view('outPallet');
    }
}
