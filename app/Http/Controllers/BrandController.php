<?php

namespace App\Http\Controllers;

use App\Exports\brandExport;
use App\Models\Brand;
use App\Models\Customer;
use App\Models\Item;
use Illuminate\Contracts\Encryption\DecryptException;
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
        return view('manageBrand', compact('brand', 'customer'));
    }

    public function makeBrand(Request $request)
    {
        $request->validate([
            'brandid' => 'required|unique:App\Models\Brand,brand_id|min:3|max:20|alpha_dash',
            'brandname' => 'required|min:2|max:50|regex:/^[\pL\s\-]+$/u',
        ], [
            'brandid.required' => 'Kolom "ID Brand" Harus Diisi',
            'brandid.unique' => 'ID Brand yang diisi sudah terambil, masukkan ID yang lain',
            'brandid.min' => 'ID Brand minimal 3 karakter',
            'brandid.max' => 'ID Brand maksimal 20 karakter',
            'brandid.alpha_dash' => 'ID Brand hanya membolehkan huruf, angka, -, _ (spasi dan simbol lainnya tidak diterima)',
            'brandname.required' => 'Kolom "Nama Brand" Harus Diisi',
            'brandname.min' => 'Nama Brand minimal 3 karakter',
            'brandname.max' => 'Nama Brand maksimal 50 karakter',
            'brandname.regex' => 'Nama Brand hanya membolehkan huruf, spasi, dan tanda penghubung(-)',
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
        // dd($id);

        try {
            $decrypted = decrypt($id);
        } catch (DecryptException $e) {
            abort(403);
        }

        $nullCheckItem = Item::where('brand_id', $decrypted)->first();
        $brand = Brand::find($decrypted);
        $deletedBrand = $brand->brand_name;
        if (is_null($nullCheckItem)) {
            // dd(1);
            $brand->delete();

            $brandDeleted = "Brand" . " \"" . $deletedBrand . "\" " . "berhasil di hapus";

            session()->flash('sukses_delete_brand', $brandDeleted);

            return redirect('manageBrand');
        } else {
            // dd(2);
            session()->flash('gagal_delete_brand', 'Brand' . " \"" . $deletedBrand . "\" " . 'Gagal Dihapus karena sudah mempunyai Item');
            return redirect('manageBrand');
        }
    }

    public function updateBrand(Request $request)
    {
        $brandInfo = Brand::where('id', $request->brandIdHidden)->first();
        $oldBrandName = $brandInfo->brand_name;

        $request->validate([
            'brandnameformupdate' => 'required|min:2|max:50|regex:/^[\pL\s\-]+$/u',
        ], [
            'brandnameformupdate.required' => 'Kolom "Nama Brand" Harus Diisi',
            'brandnameformupdate.min' => 'Nama Brand minimal 3 karakter',
            'brandnameformupdate.max' => 'Nama Brand maksimal 50 karakter',
            'brandnameformupdate.regex' => 'Nama Brand hanya membolehkan huruf, spasi, dan tanda penghubung(-)',
        ]);

        Brand::where('id', $request->brandIdHidden)->update([
            'brand_name' => $request->brandnameformupdate,
        ]);

        $request->session()->flash('sukses_editBrand', $request->brandnameformupdate);
        // $request->session()->flash('sukses_editBrand', $oldBrandName);

        return redirect('manageBrand');
    }

    public function exportCustomerBrand(Request $request)
    {
        $customer = Customer::find($request->customerBrandExport);

        $sortBrand = Brand::all()->where('customer_id', $request->customerBrandExport);

        return Excel::download(new brandExport($sortBrand), 'Brand milik ' .  $customer->customer_name . '.xlsx');
    }
}
