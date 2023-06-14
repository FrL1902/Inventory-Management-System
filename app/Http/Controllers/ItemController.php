<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Item;
use App\Models\StockHistory;
use App\Models\User;
use Illuminate\Http\Request;

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

        $request->validate([
            'itemid' => 'required|unique:App\Models\Item,item_id|min:3|max:50',
            'itemname' => 'required|unique:App\Models\Item,item_name|min:3|max:75',
        ]);

        $item->item_id = $request->itemid;
        // ini pada kurang validasi, terutama angkanya tuh, harus pake php biar validasi manual kyknya, sebenernhya kyknya sihudah bisa sama html, tp ya validasi aja lg
        $item->brand_id = $request->brandidforitem;
        $item->item_name = $request->itemname;

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

        $item->delete();

        $itemDeleted = "Item" . " \"" . $deletedItem . "\" " . "berhasil di hapus";

        session()->flash('sukses_delete_item', $itemDeleted);

        return redirect('manageItem');
    }

    public function updateItem(Request $request)
    {
        $itemInfo = Item::where('id', $request->itemIdHidden)->first();

        // dd($request->itemnameformupdate);

        $oldItemName = $itemInfo->item_name;

        $request->validate([
            'itemnameformupdate' => 'required|unique:App\Models\Item,item_name|min:3|max:75',
        ]);

        Item::where('id', $request->itemIdHidden)->update([
            'item_name' => $request->itemnameformupdate,
        ]);

        $request->session()->flash('sukses_editItem', $oldItemName);

        return redirect('manageItem');
    }

    public function addItemStock(Request $request)
    {
        // dd($request->userIdHidden);
        // dd(item_name)
        // dd($request->incomingiditem);

        $userInfo = User::where('id', $request->userIdHidden)->first();

        //proses add item
        $itemInfo = Item::where('id', $request->incomingiditem)->first();

        // dd($userInfo->name);
        // dd($itemInfo->item_name);

        $newValue = $itemInfo->stocks + $request->itemAddStock;

        Item::where('id', $request->incomingiditem)->update([
            'stocks' => $newValue,
        ]);

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

    public function reduceItemStock(Request $request)
    {

        $userInfo = User::where('id', $request->userIdHidden)->first();
        // dd($request->itemReduceStock);

        $itemInfo = Item::where('id', $request->outgoingiditem)->first();

        $newValue = $itemInfo->stocks - $request->itemReduceStock;

        Item::where('id', $request->outgoingiditem)->update([
            'stocks' => $newValue,
        ]);

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
        $item = Item::all();
        $history = StockHistory::all();
        return view('incomingItem', compact('history', 'item'));
    }

    public function add_outgoing_item_page()
    {
        $item = Item::all();
        $history = StockHistory::all();
        return view('outgoingItem', compact('history', 'item'));
    }
}
