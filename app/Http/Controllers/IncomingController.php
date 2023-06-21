<?php

namespace App\Http\Controllers;

use App\Exports\IncomingExport;
use App\Models\Brand;
use App\Models\Customer;
use App\Models\Incoming;
use App\Models\Item;
use App\Models\StockHistory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class IncomingController extends Controller
{
    public function add_incoming_item_page()
    {
        $item = Item::all(); //buat update
        // $history = StockHistory::all(); //old table,
        // return view('incomingItem', compact('history', 'item'));
        $brand = Brand::all();
        $incoming = Incoming::all();
        $customer = Customer::all();


        if ($item->isempty()) {
            // dd('kosong');
            $message = "no item is present, please input an item before accessing the \"outgoing\" or \"incoming\" page";
            session()->flash('no_item_incoming', $message);

            $brand = Brand::all();
            return view('newItem', compact('brand'));
        } else {
            return view('incomingItem', compact('incoming', 'item', 'customer', 'brand'));
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

        // $incoming->customer_id = $request->customerIdHidden; jgn pake kedua ini, ga jelas inputnya
        // $incoming->brand_id = $request->brandIdHidden;

        //reference customer_id sama brand_id mending tabel itemnya aja, jgn dari bladenya

        $incoming->customer_id = $itemInfo->customer_id;
        $incoming->brand_id = $itemInfo->brand_id;
        $incoming->item_id = $request->incomingiditem;
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
        $incoming->picture_link = 'http://127.0.0.1:8000/storage/' . $imageName;
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

    public function exportIncoming(Request $request)
    {
        // dd($request);
        // $sortCustomer = Incoming::all()->where('customer_id', '=', 3);
        $date_from = Carbon::parse($request->startRange)->startOfDay();
        $date_to = Carbon::parse($request->endRange)->endOfDay();


        // return Excel::download(new IncomingExport($sortCustomer), 'dataBarangDatang.xlsx');
        $sortAll = Incoming::all()->whereBetween('created_at', [$date_from, $date_to]);
        $formatFileName = 'DataBarangDatang ALL ' . date_format($date_from, "d-m-Y") . ' hingga ' . date_format($date_to, "d-m-Y");

        return Excel::download(new IncomingExport($sortAll), $formatFileName . '.xlsx');


        // return (new IncomingExport($sortCustomer))->download('Productos.xlsx');
    }

    public function exportIncomingCustomer(Request $request)
    {
        $customer = Customer::find($request->customerIncoming);
        $date_from = Carbon::parse($request->startRange)->startOfDay();
        $date_to = Carbon::parse($request->endRange)->endOfDay();

        $sortCustomer = Incoming::all()->where('customer_id', $request->customerIncoming)->whereBetween('created_at', [$date_from, $date_to]);
        $formatFileName = 'DataBarangDatang Customer ' . $customer->customer_name . ' ' . date_format($date_from, "d-m-Y") . ' hingga ' . date_format($date_to, "d-m-Y");

        return Excel::download(new IncomingExport($sortCustomer), $formatFileName . '.xlsx');
    }

    public function exportIncomingBrand(Request $request)
    {
        $brand = Brand::find($request->brandIncoming);
        $date_from = Carbon::parse($request->startRange)->startOfDay();
        $date_to = Carbon::parse($request->endRange)->endOfDay();

        $sortBrand = Incoming::all()->where('brand_id', $request->brandIncoming)->whereBetween('created_at', [$date_from, $date_to]);
        $formatFileName = 'DataBarangDatang Brand ' . $brand->brand_name . ' ' . date_format($date_from, "d-m-Y") . ' hingga ' . date_format($date_to, "d-m-Y");

        return Excel::download(new IncomingExport($sortBrand),  $formatFileName . '.xlsx');
    }

    public function exportIncomingItem(Request $request)
    {

        // dd($request->itemIncoming);
        $item = Item::find($request->itemIncoming);
        // dd($item->item_name);
        $date_from = Carbon::parse($request->startRange)->startOfDay();
        $date_to = Carbon::parse($request->endRange)->endOfDay();

        $sortItem = Incoming::all()->where('item_id', $request->itemIncoming)->whereBetween('created_at', [$date_from, $date_to]);
        $formatFileName = 'DataBarangDatang Item ' . $item->item_name . ' ' . date_format($date_from, "d-m-Y") . ' hingga ' . date_format($date_to, "d-m-Y");
        // return Excel::download(new IncomingExport($sortItem), 'dataBarangDatang Item.xlsx');

        return Excel::download(new IncomingExport($sortItem),  $formatFileName . '.xlsx');
    }


    //     $customer = "customerIncoming"; // Replace with the actual customer input
    // $startDate = "2023-05-01"; // Replace with the actual start date
    // $endDate = "2023-05-31"; // Replace with the actual end date

    // $filteredData = Incoming::where('customer', $customer)
    //     ->whereBetween('startRange', [$startDate, $endDate])
    //     ->get();

}
