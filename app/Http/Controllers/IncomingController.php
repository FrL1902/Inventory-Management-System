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
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class IncomingController extends Controller
{
    public function add_incoming_item_page()
    {
        $user = Auth::user();
        // // $history = StockHistory::all(); //old table,
        // $customer = Customer::all();

        // $item = Item::all(); //buat update
        if ($user->level == 'admin') {
            // $incoming = Incoming::all();
            // $incoming = DB::table('incomings')
            //     ->join('customer', 'incomings.customer_id', '=', 'customer.id')
            //     ->join('brand', 'incomings.brand_id', '=', 'brand.id')
            //     ->join('items', 'incomings.item_id', '=', 'items.id')
            //     ->select('incomings.*', 'customer.customer_name', 'brand.brand_name', 'items.item_name')->get();

            $item = DB::table('items')
                ->join('customer', 'items.customer_id', '=', 'customer.id')
                ->select('items.item_name', 'items.item_id', 'items.id')->get();

            $customer = DB::table('customer')
                ->select('customer.customer_name', 'customer.customer_id', 'customer.id')->get();

            $incoming = DB::table('incomings')
                ->join('customer', 'incomings.customer_id', '=', 'customer.id')
                ->join('brand', 'incomings.brand_id', '=', 'brand.id')
                ->join('items', 'incomings.item_id', '=', 'items.id')
                ->select('incomings.*', 'customer.customer_name', 'brand.brand_name', 'items.item_name', 'items.item_id', 'brand.brand_id')->get();

            $brand =  DB::table('brand')
                ->select('brand.id', 'brand.brand_name')->get();


            // $brand = Brand::all();
            // $customer = Customer::all();
            // dd($customer);
        } else {
            // $item = DB::table('user_accesses')
            //     ->join('items', 'user_accesses.customer_id', '=', 'items.customer_id')
            //     ->join('customer', 'user_accesses.customer_id', '=', 'customer.id')
            //     ->select()
            //     ->where('user_id', $user->id)->get();

            $item = DB::table('items')
                ->join('customer', 'items.customer_id', '=', 'customer.id')
                ->join('user_accesses', 'user_accesses.customer_id', '=', 'items.customer_id')
                ->select('items.item_name', 'items.item_id', 'items.id')
                ->where('user_id', $user->id)->get();

            // $customer = DB::table('user_accesses')
            //     ->join('customer', 'user_accesses.customer_id', '=', 'customer.id')
            //     ->select('user_accesses.*', 'customer.customer_name', 'customer.customer_id', 'customer.id as realCustomerId')
            //     ->where('user_id', $user->id)->get();
            $customer = DB::table('customer')
                ->join('user_accesses', 'user_accesses.customer_id', '=', 'customer.id')
                ->select('customer.customer_name', 'customer.customer_id', 'customer.id')
                ->where('user_id', $user->id)->get();

            // $incoming = DB::table('user_accesses')
            //     ->join('customer', 'user_accesses.customer_id', '=', 'customer.id')
            //     ->join('brand', 'user_accesses.customer_id', '=', 'brand.customer_id')
            //     ->join('items', 'user_accesses.customer_id', '=', 'items.customer_id')
            //     ->join('incomings', 'user_accesses.customer_id', '=', 'incomings.customer_id')
            //     ->select('incomings.*', 'customer.customer_name', 'brand.brand_name', 'items.item_name')
            //     ->where('user_id', $user->id)->get();

            $incoming = DB::table('incomings')
                ->join('customer', 'incomings.customer_id', '=', 'customer.id')
                ->join('brand', 'incomings.brand_id', '=', 'brand.id')
                ->join('items', 'incomings.item_id', '=', 'items.id')
                ->join('user_accesses', 'incomings.customer_id', '=', 'user_accesses.customer_id')
                ->select('incomings.*', 'customer.customer_name', 'brand.brand_name', 'items.item_name', 'items.item_id', 'brand.brand_id')
                ->where('user_id', $user->id)->get();
            // dd($incoming);

            // $brand =  DB::table('user_accesses')
            //     ->join('brand', 'user_accesses.customer_id', '=', 'brand.customer_id')
            //     ->join('customer', 'user_accesses.customer_id', '=', 'customer.id')
            //     ->select('customer.*', 'brand.*')->where('user_id', $user->id)->get();

            $brand =  DB::table('brand')
                ->join('user_accesses', 'user_accesses.customer_id', '=', 'brand.customer_id')
                ->select('brand.id', 'brand.brand_name')->where('user_id', $user->id)->get();

            // dd($brand);
            // $incoming = DB::table('user_accesses')->join('incomings', 'user_accesses.customer_id', '=', 'incomings.customer_id')->select('user_accesses.customer_id as realCustomerId', 'incomings.*')->where('user_id', $user->id)->get();
            // dd($incoming);
            // dd($customer);
        }




        // dd($customer);

        return view('incomingItem', compact('incoming', 'item', 'customer', 'brand'));

        // if ($item->isempty()) {
        //     // $message = "no item is present, please input an item before accessing the \"outgoing\" or \"incoming\" page";
        //     $message = "Tidak ada barang. Masukkan barang baru terlebih dahulu sebelum mengakses halaman \"outgoing\" atau \"incoming\"";
        //     session()->flash('no_item_incoming', $message);

        //     // $brand = Brand::all();
        //     // return view('newItem', compact('brand'));
        //     return redirect('/newItem');
        // } else {
        //     return view('incomingItem', compact('incoming', 'item', 'customer', 'brand'));
        // }
    }

    public function addItemStock(Request $request) //INCOMING, BARANG MASUK
    {
        // dd($request->incomingiditem);
        // dd($request->userIdHidden);
        $userInfo = User::where('id', $request->userIdHidden)->first();
        $itemInfo = Item::where('id', $request->incomingiditem)->first();

        $maxValueAvailable = 2147483647 - $itemInfo->stocks;

        // dd($maxValueAvailable);
        if ($request->itemAddStock > $maxValueAvailable) {
            // dd('ga bisa');
            $request->validate([
                'itemAddStock' => 'required|max:2147483647|min:1|numeric'
            ], [
                'itemAddStock.required' => 'Kolom stok harus diisi',
                'itemAddStock.max' => 'Stok melebihi 32 bit integer',
                'itemAddStock.min' => 'Stok harus melebihi 1',
                'itemAddStock.numeric' => 'input stok harus angka'
            ]);
            $request->session()->flash('intOverflow', 'Melebihi 32 bit integer (2147483647)');
            return redirect()->back();
        }

        $request->validate([ //harus tambahin error disini
            'incomingItemImage' => 'required|mimes:jpeg,png,jpg',
        ], [
            'incomingItemImage.mimes' => 'Tipe foto yang diterima hanya jpeg, jpg, dan png'
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
        // $incoming->item_name = $itemInfo->item_name;
        $incoming->stock_before = $itemInfo->stocks;
        $incoming->stock_added = $request->itemAddStock;
        $incoming->stock_now = $newValue;
        $incoming->description = $request->incomingItemDesc;
        $incoming->arrive_date = $request->itemArrive;

        $file = $request->file('incomingItemImage');
        $imageName = time() . '.' . $file->getClientOriginalExtension();
        Storage::putFileAs('public/incomingItemImage', $file, $imageName);
        $imageName = 'incomingItemImage/' . $imageName;
        $incoming->item_pictures = $imageName;
        // $incoming->picture_link = 'http://127.0.0.1:8000/storage/' . $imageName;
        $incoming->save();

        $request->session()->flash('sukses_addStock', $itemInfo->item_name);
        //end process add item

        //proses history
        $history = new StockHistory();
        $history->item_id = $itemInfo->item_id;
        $history->item_name = $itemInfo->item_name;
        // $history->stock_before = $itemInfo->stocks;
        $history->status = "BARANG DATANG";
        $history->value = $request->itemAddStock;
        // $history->stock_taken = 0;
        // $history->stock_now = $newValue;
        $history->user_who_did = $userInfo->name;

        $history->save();


        // return redirect('manageItem');
        return redirect()->back();
    }

    public function exportIncoming(Request $request)
    {
        $date_from = Carbon::parse($request->startRange)->startOfDay();
        $date_to = Carbon::parse($request->endRange)->endOfDay();

        $user = User::find($request->userIdHidden);

        // return Excel::download(new IncomingExport($sortCustomer), 'dataBarangDatang.xlsx');
        // $sortAll = Incoming::all()->whereBetween('created_at', [$date_from, $date_to]); // versi lama pake created at


        // $sortAll = Incoming::all()->whereBetween('arrive_date', [$date_from, $date_to]);

        if ($user->level == 'gudang') {
            $sortAll = DB::table('incomings')
                ->join('customer', 'incomings.customer_id', '=', 'customer.id')
                ->join('brand', 'incomings.brand_id', '=', 'brand.id')
                ->join('items', 'incomings.item_id', '=', 'items.id')
                ->join('user_accesses', 'incomings.customer_id', '=', 'user_accesses.customer_id')
                ->select('incomings.*', 'customer.customer_name', 'brand.brand_name', 'items.item_name', 'items.item_id', 'brand.brand_id')
                ->where('user_id', $request->userIdHidden)->whereBetween('arrive_date', [$date_from, $date_to])->get();
        } else {
            $sortAll = DB::table('incomings')
                ->join('customer', 'incomings.customer_id', '=', 'customer.id')
                ->join('brand', 'incomings.brand_id', '=', 'brand.id')
                ->join('items', 'incomings.item_id', '=', 'items.id')
                ->select('incomings.*', 'customer.customer_name', 'brand.brand_name', 'items.item_name', 'items.item_id', 'brand.brand_id')
                ->whereBetween('arrive_date', [$date_from, $date_to])->get();
        }

        $formatFileName = 'DataBarangDatang ALL ' . date_format($date_from, "d-m-Y") . ' hingga ' . date_format($date_to, "d-m-Y");

        return Excel::download(new IncomingExport($sortAll), $formatFileName . '.xlsx');
        // return (new IncomingExport($sortCustomer))->download('Productos.xlsx');
    }

    public function exportIncomingCustomer(Request $request)
    {
        $customer = Customer::find($request->customerIncoming);
        $date_from = Carbon::parse($request->startRange)->startOfDay();
        $date_to = Carbon::parse($request->endRange)->endOfDay();

        // $sortCustomer = Incoming::all()->where('customer_id', $request->customerIncoming)->whereBetween('created_at', [$date_from, $date_to]); // versi lama pake created at
        $sortCustomer = Incoming::all()->where('customer_id', $request->customerIncoming)->whereBetween('arrive_date', [$date_from, $date_to]);
        $formatFileName = 'DataBarangDatang Customer ' . $customer->customer_name . ' ' . date_format($date_from, "d-m-Y") . ' hingga ' . date_format($date_to, "d-m-Y");

        return Excel::download(new IncomingExport($sortCustomer), $formatFileName . '.xlsx');
    }

    public function exportIncomingBrand(Request $request)
    {
        $brand = Brand::find($request->brandIncoming);
        $date_from = Carbon::parse($request->startRange)->startOfDay();
        $date_to = Carbon::parse($request->endRange)->endOfDay();

        // dd($request->brandIncoming);

        // $sortBrand = Incoming::all()->where('brand_id', $request->brandIncoming)->whereBetween('created_at', [$date_from, $date_to]); // versi lama pake created at
        $sortBrand = Incoming::all()->where('brand_id', $request->brandIncoming)->whereBetween('arrive_date', [$date_from, $date_to]);
        $formatFileName = 'DataBarangDatang Brand ' . $brand->brand_name . ' ' . date_format($date_from, "d-m-Y") . ' hingga ' . date_format($date_to, "d-m-Y");

        return Excel::download(new IncomingExport($sortBrand),  $formatFileName . '.xlsx');
    }

    public function exportIncomingItem(Request $request)
    {
        $item = Item::find($request->itemIncoming);
        $date_from = Carbon::parse($request->startRange)->startOfDay();
        $date_to = Carbon::parse($request->endRange)->endOfDay();

        // $sortItem = Incoming::all()->where('item_id', $request->itemIncoming)->whereBetween('created_at', [$date_from, $date_to]); // versi lama pake created at
        $sortItem = Incoming::all()->where('item_id', $request->itemIncoming)->whereBetween('arrive_date', [$date_from, $date_to]);
        $formatFileName = 'DataBarangDatang Item ' . $item->item_name . ' ' . date_format($date_from, "d-m-Y") . ' hingga ' . date_format($date_to, "d-m-Y");

        return Excel::download(new IncomingExport($sortItem),  $formatFileName . '.xlsx');
    }

    public function deleteItemIncoming($id)
    {
        try {
            $decrypted = decrypt($id);
        } catch (DecryptException $e) {
            abort(403);
        }

        $incomingInfo = Incoming::where('id', $decrypted)->first();
        $itemInfo = Item::where('id', $incomingInfo->item_id)->first();

        $newValue = $itemInfo->stocks - $incomingInfo->stock_added;

        if ($newValue < 0) {
            session()->flash('newValueMinus', 'Gagal karena stock akan kurang dari 0 (minus)');
            return redirect()->back();
        }

        Item::where('id', $incomingInfo->item_id)->update([ //kurangin stock sesuai jumlah stock dalam incoming ini
            'stocks' => $newValue
        ]);

        Storage::delete('public/' . $incomingInfo->item_pictures);
        $incomingInfo->delete();
        // session()->flash('suksesDeleteIncoming', 'Sukses hapus data kedatangan barang ' . $itemInfo->item_name . ' (' + intval($itemInfo->stocks) . ') stock');
        session()->flash('suksesDeleteIncoming', 'Sukses hapus data kedatangan barang ' . $itemInfo->item_name);
        return redirect()->back();
    }

    public function updateIncomingData(Request $request)
    {

        if ($request->file('itemImage') || $request->incomingEdit) {
            $incomingInfo = Incoming::where('id', $request->itemIdHidden)->first();

            // ini buat update valuenya
            $itemInfo = Item::where('id', $incomingInfo->item_id)->first();


            $file = $request->file('itemImage');

            // validasi data buat mastiin gambar nggak null
            if ($file != null) {
                $request->validate([
                    'itemImage' => 'mimes:jpeg,png,jpg',
                ], [
                    'itemImage.mimes' => 'Tipe foto yang diterima hanya jpeg, jpg, dan png'
                ]);
            }

            // buat update image
            if ($file != null) {
                // dd('msk');
                $request->validate([
                    'itemImage' => 'mimes:jpeg,png,jpg',
                ], [
                    'itemImage.mimes' => 'Tipe foto yang diterima hanya jpeg, jpg, dan png'
                ]);

                $imageName = time() . '.' . $file->getClientOriginalExtension();
                Storage::putFileAs('public/incomingItemImage', $file, $imageName);
                $imageName = 'incomingItemImage/' . $imageName;

                Storage::delete('public/' . $incomingInfo->item_pictures);

                Incoming::where('id', $request->itemIdHidden)->update([
                    'item_pictures' => $imageName,
                ]);


                $file = $request->file('incomingItemImage');
            } else {
                // dd("lha");
                Incoming::where('id', $request->itemIdHidden)->update([
                    'item_pictures' => $incomingInfo->item_pictures,
                ]);
            }

            // buat VALUE
            if ($request->incomingEdit != null) {

                // ini buat update data stocks yang di itemnya
                $newValue = $itemInfo->stocks - $incomingInfo->stock_added + $request->incomingEdit;
                // ini buat update data stock_now yang di incomingnya
                $newStockNow = $incomingInfo->stock_now - $incomingInfo->stock_added + $request->incomingEdit;

                if ($newValue < 0) {
                    session()->flash('newValueMinus', 'Gagal karena stock akan kurang dari 0 (minus)');
                    return redirect()->back();
                }

                Item::where('id', $incomingInfo->item_id)->update([ //kurangin stock sesuai jumlah stock dalam incoming ini
                    'stocks' => $newValue
                ]);

                Incoming::where('id', $request->itemIdHidden)->update([
                    'stock_added' => $request->incomingEdit,
                    'stock_now' => $newStockNow
                ]);

                session()->flash('suksesUpdateIncoming', 'Sukses update data kedatangan barang ' . $itemInfo->item_name);
            } else {
                $request->session()->flash('suksesUpdateIncoming', 'Sukses update data kedatangan barang ' . $itemInfo->item_name);
            }
        } else {
            $request->session()->flash('noData_editItem', 'tidak ada');
        }
        return redirect()->back();
    }
}
