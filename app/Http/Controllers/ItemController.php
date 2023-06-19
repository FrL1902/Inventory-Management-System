<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Customer;
use App\Models\Incoming;
use App\Models\Item;
use App\Models\Outgoing;
use App\Models\StockHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        return view('manageItem', compact('item'));
    }

    public function item_history_page()
    {
        $history = StockHistory::all();
        return view('itemHistory', compact('history'));
    }

    public function deleteItem($id)
    {

        $item = Item::find($id);

        $deletedItem = $item->item_name;

        Storage::delete('public/' . $item->item_pictures);

        $item->delete();

        $itemDeleted = "Item" . " \"" . $deletedItem . "\" " . "berhasil di hapus";

        session()->flash('sukses_delete_item', $itemDeleted);

        return redirect('manageItem');
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

    public function addItemStock(Request $request) //INCOMING, BARANG MASUK
    {
        $userInfo = User::where('id', $request->userIdHidden)->first();
        $itemInfo = Item::where('id', $request->incomingiditem)->first();

        $request->validate([
            'incomingItemImage' => 'required|mimes:jpeg,png,jpg',
        ]);

        $newValue = $itemInfo->stocks + $request->itemAddStock;

        Item::where('id', $request->incomingiditem)->update([ //nambahin stock di tabel item
            'stocks' => $newValue,
        ]);

        // masukin data ke tabel incoming
        $incoming = new Incoming();
        $incoming->customer_id = $request->customerIdHidden;
        $incoming->brand_id = $request->brandIdHidden;
        $incoming->item_id = $request->itemIdHidden;
        $incoming->item_name = $itemInfo->item_name;
        $incoming->stock_before = $itemInfo->stocks;
        $incoming->stock_added = $request->itemAddStock;
        $incoming->stock_now = $newValue;
        $incoming->description = $request->incomingItemDesc;

        $file = $request->file('incomingItemImage');
        $imageName = time() . '.' . $file->getClientOriginalExtension();
        Storage::putFileAs('public/incomingItemImage', $file, $imageName);
        $imageName = 'incomingItemImage/' . $imageName;
        $incoming->item_pictures = $imageName;
        $incoming->save();

        $request->session()->flash('sukses_addStock', $itemInfo->item_name);
        //end process add item

        //proses history
        $history = new StockHistory();
        $history->item_name = $itemInfo->item_name;
        $history->stock_before = $itemInfo->stocks;
        $history->stock_added = $request->itemAddStock;
        $history->stock_taken = 0;
        $history->stock_now = $newValue;
        $history->user_who_did = $userInfo->name;

        $history->save();


        return redirect('manageItem');
    }

    public function reduceItemStock(Request $request) //OUTGOING, BARANG KELUAR
    {

        $userInfo = User::where('id', $request->userIdHidden)->first();
        $itemInfo = Item::where('id', $request->outgoingiditem)->first();

        $request->validate([
            'outgoingItemImage' => 'required|mimes:jpeg,png,jpg',
        ]);

        $newValue = $itemInfo->stocks - $request->itemReduceStock;

        Item::where('id', $request->outgoingiditem)->update([
            'stocks' => $newValue,
        ]);

        $outgoing = new Outgoing();

        $outgoing->customer_id = $request->customerIdHidden;
        $outgoing->brand_id = $request->brandIdHidden;
        $outgoing->item_id = $request->itemIdHidden;
        $outgoing->item_name = $itemInfo->item_name;
        $outgoing->stock_before = $itemInfo->stocks;
        $outgoing->stock_taken = $request->itemReduceStock;
        $outgoing->stock_now = $newValue;
        $outgoing->description = $request->outgoingItemDesc;

        $file = $request->file('outgoingItemImage');
        $imageName = time() . '.' . $file->getClientOriginalExtension();
        Storage::putFileAs('public/outgoingItemImage', $file, $imageName);
        $imageName = 'outgoingItemImage/' . $imageName;
        $outgoing->item_pictures = $imageName;
        $outgoing->save();



        $request->session()->flash('sukses_reduceStock', $itemInfo->item_name);

        $history = new StockHistory();
        $history->item_name = $itemInfo->item_name;
        $history->stock_before = $itemInfo->stocks;
        $history->stock_added = 0;
        $history->stock_taken = $request->itemReduceStock;
        $history->stock_now = $newValue;
        $history->user_who_did = $userInfo->name;

        $history->save();


        return redirect('manageItem');
    }

    public function add_incoming_item_page()
    {
        $item = Item::all(); //buat update
        // $history = StockHistory::all(); //old table,
        // return view('incomingItem', compact('history', 'item'));
        $incoming = Incoming::all();

        if ($item->isempty()) {
            // dd('kosong');
            $message = "no item is present, please input an item before accessing the \"outgoing\" or \"incoming\" page";
            session()->flash('no_item_incoming', $message);

            $brand = Brand::all();
            return view('newItem', compact('brand'));
        } else {
            return view('incomingItem', compact('incoming', 'item'));
        }
    }

    public function add_outgoing_item_page()
    {
        $item = Item::all();
        $outgoing = Outgoing::all();

        if ($item->isempty()) {
            $message = "no item is present, please input an item before accessing the \"outgoing\" or \"incoming\" page";
            session()->flash('no_item_outgoing', $message);

            $brand = Brand::all();
            return view('newItem', compact('brand'));
        } else {
            return view('outgoingItem', compact('outgoing', 'item'));
        }
    }
}
