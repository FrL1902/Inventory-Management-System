<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Incoming;
use App\Models\Item;
use App\Models\StockHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IncomingController extends Controller
{
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

    public function addItemStock(Request $request) //INCOMING, BARANG MASUK
    {
        $userInfo = User::where('id', $request->userIdHidden)->first();
        $itemInfo = Item::where('id', $request->incomingiditem)->first();

        $request->validate([ //harus tambahin error disini
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
}
