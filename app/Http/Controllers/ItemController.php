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
            'itemid' => 'required|unique:App\Models\Item,item_id|min:3|max:50',
            'itemname' => 'required|unique:App\Models\Item,item_name|min:3|max:75',
            'itemImage' => 'required|mimes:jpeg,png,jpg',
        ]);

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

        //ini kalo input angkanya null, di set ke 0
        if (is_null($request->itemStock)) {
            $item->stocks = 0;
        } else {
            $item->stocks = $request->itemStock;
        }


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
            $itemDeleted = "Item" . " \"" . $deletedItem . "\" " . "berhasil di hapus";
            session()->flash('sukses_delete_item', $itemDeleted);
            return redirect('manageItem');
        } else {
            session()->flash('gagal_delete_item', 'Item'. " \"" . $deletedItem . "\" " . 'Gagal Dihapus karena sudah mempunyai Sejarah Incoming/Outgoing');
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
                ]);
            }
            if ($request->itemnameformupdate != null) {
                $request->validate([
                    'itemnameformupdate' => 'required|unique:App\Models\Item,item_name|min:3|max:75',
                ]);
            }


            // buat update image
            if ($file != null) {
                // dd("ms");
                $request->validate([
                    'itemImage' => 'mimes:jpeg,png,jpg',
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
