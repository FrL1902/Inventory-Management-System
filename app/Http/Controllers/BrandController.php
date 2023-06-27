<?php

namespace App\Http\Controllers;

use App\Exports\brandExport;
use App\Models\Brand;
use App\Models\Customer;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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
        $customer = Customer::all();
        $brand = Brand::all();
        return view('manageBrand', compact('brand' , 'customer'));
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

    public function updateBrand(Request $request)
    {
        $brandInfo = Brand::where('id', $request->brandIdHidden)->first();
        $oldBrandName = $brandInfo->brand_name;

        $request->validate([
            'brandnameformupdate' => 'required|min:2|max:50',
        ]);

        Brand::where('id', $request->brandIdHidden)->update([
            'brand_name' => $request->brandnameformupdate,
        ]);

        $request->session()->flash('sukses_editBrand', $oldBrandName);

        return redirect('manageBrand');
    }

    public function exportCustomerBrand(Request $request){
        $customer = Customer::find($request->customerBrandExport);

        $sortBrand = Brand::all()->where('customer_id', $request->customerBrandExport);

        return Excel::download(new brandExport($sortBrand), 'Brand milik ' .  $customer->customer_name .'.xlsx');
    }
}
