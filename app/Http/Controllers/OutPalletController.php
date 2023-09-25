<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OutPalletController extends Controller
{
    //
    public function out_pallet_page()
    {
        $outpallet = DB::table('outpallet')
            ->join('items', 'outpallet.item_id', '=', 'items.item_id')
            ->join('customer', 'items.customer_id', '=', 'customer.customer_id')
            ->join('brand', 'items.brand_id', '=', 'brand.brand_id')
            ->select('outpallet.*', 'items.item_name', 'customer.customer_name', 'brand.brand_name')->get();

        return view('outPallet', compact('outpallet'));
    }
}
