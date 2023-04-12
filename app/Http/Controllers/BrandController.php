<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    //
    public function new_brand_page()
    {

        $customer = Customer::all();
        return view('newBrand', compact('customer'));
    }

    public function manage_brand_page()
    {

        return view('manageBrand');
    }

    public function makeBrand(Request $request)
    {
        // dd('masuk');
        return $request->input();
    }
}
