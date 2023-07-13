<?php

namespace App\Http\Controllers;

use App\Exports\editItemExport;
use App\Models\Brand;
use App\Models\Customer;
use App\Models\Incoming;
use App\Models\Item;
use App\Models\Outgoing;
use App\Models\StockHistory;
use App\Models\User;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ItemController extends Controller
{
    public function new_item_page()
    {
        $brand = Brand::all();
        return view('newItem', compact('brand'));
    }

    public function makeItem(Request $request)
    {
        $item = new Item();

        // $request->validate([
        //     'brandid' => 'required|unique:App\Models\Brand,brand_id|min:3|max:20',
        //     'brandname' => 'required|min:2|max:50',
        // ]);

        $customer = Brand::where('id', $request->brandidforitem)->first();

        // dd($customer->customer_id);

        $request->validate([
            'itemid' => 'required',
            'itemname' => 'required',
            'itemImage' => 'required',
        ], [
            'itemid.required' => 'Kolom ID Barang harus diisi',
            'itemname.required' => 'Kolom Nama Barang harus diisi',
            'itemImage.required' => 'Harus ada foto barang',
        ]);

        $request->validate([
            'itemid' => 'required|unique:App\Models\Item,item_id|min:3|max:20|alpha_dash',
            'itemname' => 'required|unique:App\Models\Item,item_name|min:3|max:75|regex:/^[\pL\s\-\0-9]+$/u', //ga perlu pake unique sih, soalnya udah ada item_id, tp gpp buat skrg deh, //ini regex lama tanpa pake number /^[\pL\s\-]+$/u  , ini yg baru  /^[\pL\s\-\0-9]+$/u
            'itemImage' => 'required|mimes:jpeg,png,jpg',
        ], [
            'itemid.required' => 'Kolom ID Barang harus diisi',
            'itemid.unique' => 'ID Barang yang diisi sudah terambil, masukkan ID yang lain',
            'itemid.min' => 'ID Barang minimal 3 karakter',
            'itemid.max' => 'ID Barang maksimal 20 karakter',
            'itemid.alpha_dash' => 'ID Barang hanya membolehkan huruf, angka, -, _ (spasi dan simbol lainnya tidak diterima)',
            'itemname.required' => 'Kolom Nama Barang harus diisi',
            'itemname.unique' => 'Nama Barang yang diisi sudah terambil, masukkan nama yang lain',
            'itemname.min' => 'Nama Barang minimal 3 karakter',
            'itemname.max' => 'Nama Barang maksimal 75 karakter',
            'itemname.regex' => 'Nama Barang hanya membolehkan huruf, angka, spasi, dan tanda penghubung(-)',
            'itemImage.required' => 'Harus ada foto barang',
            'itemImage.mimes' => 'Tipe foto yang diterima hanya jpeg, jpg, dan png'
        ]);

        //ini kalo input angkanya null, di set ke 0
        if (is_null($request->itemStock)) {
            $item->stocks = 0;
        } else {
            $request->validate([
                'itemStock' => 'max:2147483647|min:0|numeric'
            ],[
                'itemStock.max' => 'Stok melebihi 32 bit integer (2147483647)',
                'itemStock.min' => 'Stok tidak boleh angka negatif',
                'itemStock.numeric' => 'input stok harus angka'
            ]);
            $item->stocks = $request->itemStock;
        }

        $file = $request->file('itemImage');
        $imageName = time() . '.' . $file->getClientOriginalExtension();
        Storage::putFileAs('public/itemImages', $file, $imageName);
        $imageName = 'itemImages/' . $imageName;

        $item->item_id = $request->itemid;
        // ini pada kurang validasi, terutama angkanya tuh, harus pake php biar validasi manual kyknya, sebenernhya kyknya sihudah bisa sama html, tp ya validasi aja lg
        $item->brand_id = $request->brandidforitem;
        $item->item_name = $request->itemname;
        $item->item_pictures = $imageName;
        $item->customer_id = $customer->customer_id;



        $item->save();

        // $item->save();

        // $itemAdded = "Brand " . "\"" . $request->brandname . "\"" . " berhasil di tambahkan";

        $request->session()->flash('sukses_addNewItem', $request->itemname);

        // dd($request->itemStock);
        return redirect()->back();
    }

    public function manage_item_page()
    {
        $item = Item::all();
        $customer = Customer::all();
        $brand = Brand::all();
        return view('manageItem', compact('item', 'customer', 'brand'));
    }

    public function item_history_page()
    {
        session()->forget('deleteFilterButton');
        $history = StockHistory::all();
        return view('itemHistory', compact('history'));
    }

    public function deleteItem($id)
    {
        try {
            $decrypted = decrypt($id);
        } catch (DecryptException $e) {
            abort(403);
        }


        $itemIncoming = Incoming::where('item_id', $decrypted)->first();
        $itemOutgoing = Outgoing::where('item_id', $decrypted)->first();
        $item = Item::find($decrypted);
        $deletedItem = $item->item_name;

        if (is_null($itemIncoming) && is_null($itemOutgoing)) {
            Storage::delete('public/' . $item->item_pictures);
            $item->delete();
            $itemDeleted = "Barang" . " \"" . $deletedItem . "\" " . "berhasil di hapus";
            session()->flash('sukses_delete_item', $itemDeleted);
            return redirect('manageItem');
        } else {
            session()->flash('gagal_delete_item', 'Item' . " \"" . $deletedItem . "\" " . 'Gagal Dihapus karena sudah mempunyai Sejarah Incoming/Outgoing');
            return redirect('manageItem');
        }
    }

    public function updateItem(Request $request)
    {
        // kalo ada data yang dimasukin
        if ($request->file('itemImage') || $request->itemnameformupdate) {

            $itemInfo = Item::where('id', $request->itemIdHidden)->first();

            $file = $request->file('itemImage');


            // validasi data buat mastiin nggak null
            if ($file != null) {
                $request->validate([
                    'itemImage' => 'mimes:jpeg,png,jpg',
                ], [
                    'itemImage.mimes' => 'Tipe foto yang diterima hanya jpeg, jpg, dan png'
                ]);
            }
            if ($request->itemnameformupdate != null) {
                $request->validate([
                    'itemnameformupdate' => 'unique:App\Models\Item,item_name|min:3|max:75|regex:/^[\pL\s\-\0-9]+$/u', //updated to include numbers
                ], [
                    'itemnameformupdate.unique' => 'Nama Barang yang diisi sudah terambil, masukkan nama yang lain',
                    'itemnameformupdate.min' => 'Nama Barang minimal 3 karakter',
                    'itemnameformupdate.max' => 'Nama Barang maksimal 75 karakter',
                    'itemnameformupdate.regex' => 'Nama Barang hanya membolehkan huruf, angka, spasi, dan tanda penghubung(-)',
                ]);
            }


            // buat update image
            if ($file != null) {
                // dd("ms");
                $request->validate([
                    'itemImage' => 'mimes:jpeg,png,jpg',
                ], [
                    'itemImage.mimes' => 'Tipe foto yang diterima hanya jpeg, jpg, dan png'
                ]);

                $imageName = time() . '.' . $file->getClientOriginalExtension();
                Storage::putFileAs('public/itemImages', $file, $imageName);
                $imageName = 'itemImages/' . $imageName;

                Storage::delete('public/' . $itemInfo->item_pictures);

                Item::where('id', $request->itemIdHidden)->update([
                    'item_pictures' => $imageName,
                ]);
            } else {
                // dd("lha");
                Item::where('id', $request->itemIdHidden)->update([
                    'item_pictures' => $itemInfo->item_pictures,
                ]);
            }

            // buat update nama
            if ($request->itemnameformupdate != null) {

                $oldItemName = $itemInfo->item_name;

                Item::where('id', $request->itemIdHidden)->update([
                    'item_name' => $request->itemnameformupdate,
                ]);

                $request->session()->flash('sukses_editItem', $oldItemName);
            } else {
                $request->session()->flash('sukses_editItem', $request->item_name);
            }
        } else {
            $request->session()->flash('noData_editItem', 'tidak ada');
        }

        return redirect('manageItem');
    }

    public function exportCustomerItem(Request $request)
    {
        $customer = Customer::find($request->customerItemExport);

        $sortItem = Item::all()->where('customer_id', $request->customerItemExport);

        return Excel::download(new editItemExport($sortItem), 'Item milik Customer ' .  $customer->customer_name . '.xlsx');
    }

    public function exportBrandItem(Request $request)
    {
        $brand = Brand::find($request->brandItemExport);

        $sortItem = Item::all()->where('brand_id', $request->brandItemExport);

        return Excel::download(new editItemExport($sortItem), 'Item milik Brand ' .  $brand->brand_name . '.xlsx');
    }
}
