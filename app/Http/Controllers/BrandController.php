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

        $request->validate([
            'brandid' => 'required|unique:App\Models\Brand,brand_id|min:3|max:20',
            'brandname' => 'required|min:2|max:50',
        ]);

        $item = new Brand();
        $item->customer_id = $request->customeridforbrand;
        $item->brand_id = $request->brandid;
        $item->brand_name = $request->brandname;

        $item->save();

        $itemAdded = "Brand " . "\"" . $request->brandname . "\"" . " berhasil di tambahkan";

        $request->session()->flash('sukses_addNewBrand', $itemAdded);

        return redirect()->back();

        // return $request->input();
    }

    public function deleteBrand($id)
    {
        $brand = Brand::find($id);

        $deletedBrand = $brand->brand_name;

        $brand->delete();

        $brandDeleted = "Brand" . " \"" . $deletedBrand . "\" " . "berhasil di hapus";

        session()->flash('sukses_delete_brand', $brandDeleted);

        return redirect('manageBrand');
    }
}
