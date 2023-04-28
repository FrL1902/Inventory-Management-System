<?php

namespace App\Http\Controllers;

use App\Models\Brand;
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
        $brand = Brand::all();
        return view('manageBrand', compact('brand'));
    }

    public function makeBrand(Request $request)
    {
        // dd('masuk');
        $item = new Brand();
        $item->customer_id = $request->customeridforbrand;
        $item->brand_id = $request->brandid;
        $item->brand_name = $request->brandname;

        $item->save();

        return redirect()->back();

        // return $request->input();
    }
}
