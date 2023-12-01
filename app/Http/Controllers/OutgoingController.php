<?php

namespace App\Http\Controllers;

use App\Exports\OutgoingExport;
use App\Models\Brand;
use App\Models\Customer;
use App\Models\Incoming;
use App\Models\Item;
use App\Models\Outgoing;
use App\Models\StockHistory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;

class OutgoingController extends Controller
{
    public function add_outgoing_item_page()
    {
        $user = Auth::user();

        // $item = DB::table('items')
        //     ->join('customer', 'items.customer_id', '=', 'customer.customer_id')
        //     ->select('items.item_name', 'items.item_id')->get();

        // $customer = DB::table('customer')
        //     ->select('customer.customer_name', 'customer.customer_id')->get();

        // $outgoing = DB::table('outgoings')
        //     ->join('customer', 'outgoings.customer_id', '=', 'customer.customer_id')
        //     ->join('brand', 'outgoings.brand_id', '=', 'brand.brand_id')
        //     ->join('items', 'outgoings.item_id', '=', 'items.item_id')
        //     ->select('outgoings.*', 'customer.customer_name', 'brand.brand_name', 'items.item_name', 'items.item_id', 'brand.brand_id')->get();

        // $brand =  DB::table('brand')
        //     ->select('brand.brand_id', 'brand.brand_name')->get();

        if ($user->level == 'admin') {

            $item = DB::table('items')
                ->join('customer', 'items.customer_id', '=', 'customer.customer_id')
                ->select('items.item_name', 'items.item_id', 'items.item_id')->get();

            $customer = DB::table('customer')
                ->select('customer.customer_name', 'customer.customer_id', 'customer.customer_id')->get();

            $outgoing = DB::table('outgoings')
                ->join('customer', 'outgoings.customer_id', '=', 'customer.customer_id')
                ->join('brand', 'outgoings.brand_id', '=', 'brand.brand_id')
                ->join('items', 'outgoings.item_id', '=', 'items.item_id')
                ->select('outgoings.*', 'customer.customer_name', 'brand.brand_name', 'items.item_name', 'items.item_id', 'brand.brand_id')->get();

            $brand =  DB::table('brand')
                ->select('brand.brand_id', 'brand.brand_name')->get();
        } else {
            $item = DB::table('items')
                ->join('customer', 'items.customer_id', '=', 'customer.customer_id')
                ->join('user_accesses', 'user_accesses.customer_id', '=', 'items.customer_id')
                ->select('items.item_name', 'items.item_id', 'items.item_id')
                ->where('user_id', $user->name)->get();

            $customer = DB::table('customer')
                ->join('user_accesses', 'user_accesses.customer_id', '=', 'customer.customer_id')
                ->select('customer.customer_name', 'customer.customer_id', 'customer.customer_id')
                ->where('user_id', $user->name)->get();

            $outgoing = DB::table('outgoings')
                ->join('customer', 'outgoings.customer_id', '=', 'customer.customer_id')
                ->join('brand', 'outgoings.brand_id', '=', 'brand.brand_id')
                ->join('items', 'outgoings.item_id', '=', 'items.item_id')
                ->join('user_accesses', 'outgoings.customer_id', '=', 'user_accesses.customer_id')
                ->select('outgoings.*', 'customer.customer_name', 'brand.brand_name', 'items.item_name', 'items.item_id', 'brand.brand_id')
                ->where('user_id', $user->name)->get();

            $brand =  DB::table('brand')
                ->join('user_accesses', 'user_accesses.customer_id', '=', 'brand.customer_id')
                ->select('brand.brand_id', 'brand.brand_name')->where('user_id', $user->name)->get();
        }

        return view('outgoingItem', compact('outgoing', 'item', 'customer', 'brand'));
    }

    public function reduceItemStock(Request $request) //OUTGOING, BARANG KELUAR
    {
        $request->validate([
            'outgoingiditem' => 'required',
            'itemReduceStock' => 'required|max:2147483647|min:1|numeric',
            'outgoingItemDesc' => 'required|min:1|max:255',
            'itemDepart' => 'required',
            'outgoingItemImage' => 'required|mimes:jpeg,png,jpg|max:10240',
        ], [
            'outgoingiditem.required' => 'Kolom "Nama Barang" harus dipilih',
            'itemReduceStock.required' => 'Kolom "Stok" harus diisi',
            'itemReduceStock.max' => 'Stok melebihi 32 bit integer',
            'itemReduceStock.min' => 'Stok harus melebihi 1',
            'itemReduceStock.numeric' => 'input stok harus angka',
            'outgoingItemDesc.required' => 'Kolom "Deskripsi" harus diisi',
            'outgoingItemDesc.min' => 'Deskripsi minimal 1 karakter',
            'outgoingItemDesc.max' => 'Deskripsi maksimal 255 karakter',
            'itemDepart.required' => 'Kolom "Tanggal Barang Keluar" harus diisi',
            'outgoingItemImage.required' => 'Kolom "Gambar Barang Keluar" harus diisi',
            'outgoingItemImage.mimes' => 'Tipe foto yang diterima hanya jpeg, jpg, dan png',
            'outgoingItemImage.max' => 'Ukuran foto harus dibawah 10 MB',
        ]);

        $userInfo = User::where('id', $request->userIdHidden)->first();
        $itemInfo = Item::where('item_id', $request->outgoingiditem)->first();

        if ($request->itemReduceStock > $itemInfo->stocks) {
            $request->session()->flash('gagalReduceValue', $itemInfo->item_name);
            // return redirect('manageItem');
            return redirect()->back();
        }

        $outgoing = new Outgoing();

        $outgoing->customer_id = $itemInfo->customer_id;
        $outgoing->brand_id = $itemInfo->brand_id;
        $outgoing->item_id = $request->outgoingiditem;
        // $outgoing->item_name = $itemInfo->item_name;
        // $outgoing->stock_before = $itemInfo->stocks;
        $outgoing->stock_taken = $request->itemReduceStock;
        // $outgoing->stock_now = $newValue;
        $outgoing->description = $request->outgoingItemDesc;
        $outgoing->depart_date = $request->itemDepart;

        // $file = $request->file('outgoingItemImage');
        // $imageName = time() . '.' . $file->getClientOriginalExtension();
        // Storage::putFileAs('public/outgoingItemImage', $file, $imageName);
        // $imageName = 'outgoingItemImage/' . $imageName;

        $file = $request->file('outgoingItemImage');
        $imageName = time() . '.' . $file->getClientOriginalExtension();
        $destination = public_path('storage\outgoingItemImage') . '\\' . $imageName;
        // dd(public_path());
        // dd($destination);
        $data = getimagesize($file);
        $width = $data[0];
        $height = $data[1];
        // dd($width . ' ' . $height);
        // image resizing with "Image Intervention"
        if ($width > $height) {
            $resize_image = Image::make($file->getRealPath())->resize(
                1920,
                1080
            )->save($destination);
        } else {
            $resize_image = Image::make($file->getRealPath())->resize(
                1080,
                1920
            )->save($destination);
        }
        // $resize_image->save($destination);
        // image resizing with "Image Intervention" end line of code
        $imageName = 'outgoingItemImage/' . $imageName;
        //

        $outgoing->item_pictures = $imageName;
        // $outgoing->picture_link = 'http://127.0.0.1:8000/storage/' . $imageName;
        $outgoing->save();

        $newValue = $itemInfo->stocks - $request->itemReduceStock;

        Item::where('item_id', $request->outgoingiditem)->update([
            'stocks' => $newValue,
        ]);



        // history
        $history = new StockHistory();
        $history->item_id = $itemInfo->item_id;
        $history->item_name = $itemInfo->item_name;
        $history->status = "BARANG KELUAR";
        $history->value = $request->itemReduceStock;
        $history->user_who_did = $userInfo->name;
        $history->user_action_date = $request->itemDepart;
        $history->supplier = "";
        $history->save();

        $request->session()->flash('sukses_reduceStock', $itemInfo->item_name);
        return redirect()->back();
    }

    public function exportOutgoing(Request $request)
    {
        $date_from = Carbon::parse($request->startRange)->startOfDay();
        $date_to = Carbon::parse($request->endRange)->endOfDay();

        $user = Auth::user();
        // $user = User::find($request->userIdHidden);

        // $sortAll = Outgoing::all()->whereBetween('created_at', [$date_from, $date_to]); // versi lama pake created at
        // $sortAll = Outgoing::all()->whereBetween('depart_date', [$date_from, $date_to]);

        // $sortAll = DB::table('outgoings')
        //     ->join('customer', 'outgoings.customer_id', '=', 'customer.customer_id')
        //     ->join('brand', 'outgoings.brand_id', '=', 'brand.brand_id')
        //     ->join('items', 'outgoings.item_id', '=', 'items.item_id')
        //     ->select('outgoings.*', 'customer.customer_name', 'brand.brand_name', 'items.item_name', 'items.item_id', 'brand.brand_id')
        //     ->whereBetween('depart_date', [$date_from, $date_to])->get();

        if ($user->level == 'admin') {
            $sortAll = DB::table('outgoings')
                ->join('customer', 'outgoings.customer_id', '=', 'customer.customer_id')
                ->join('brand', 'outgoings.brand_id', '=', 'brand.brand_id')
                ->join('items', 'outgoings.item_id', '=', 'items.item_id')
                ->select('outgoings.*', 'customer.customer_name', 'brand.brand_name', 'items.item_name', 'items.item_id', 'brand.brand_id')
                ->whereBetween('depart_date', [$date_from, $date_to])->get();
        } else {
            $sortAll = DB::table('outgoings')
                ->join('customer', 'outgoings.customer_id', '=', 'customer.customer_id')
                ->join('brand', 'outgoings.brand_id', '=', 'brand.brand_id')
                ->join('items', 'outgoings.item_id', '=', 'items.item_id')
                ->join('user_accesses', 'outgoings.customer_id', '=', 'user_accesses.customer_id')
                ->select('outgoings.*', 'customer.customer_name', 'brand.brand_name', 'items.item_name', 'items.item_id', 'brand.brand_id')
                ->where('user_id', $user->name)->whereBetween('depart_date', [$date_from, $date_to])->get();
        }

        $formatFileName = 'DataBarangKeluar ALL ' . date_format($date_from, "d-m-Y") . ' hingga ' . date_format($date_to, "d-m-Y");

        return Excel::download(new OutgoingExport($sortAll), $formatFileName . '.xlsx');
    }

    public function exportOutgoingCustomer(Request $request)
    {
        $customer = Customer::find($request->customerOutgoing);
        $date_from = Carbon::parse($request->startRange)->startOfDay();
        $date_to = Carbon::parse($request->endRange)->endOfDay();

        // $sortCustomer = Outgoing::all()->where('customer_id', $request->customerOutgoing)->whereBetween('created_at', [$date_from, $date_to]); // versi lama pake created at
        $sortCustomer = Outgoing::all()->where('customer_id', $request->customerOutgoing)->whereBetween('depart_date', [$date_from, $date_to]);
        $formatFileName = 'DataBarangKeluar Customer ' . $customer->customer_name . ' ' . date_format($date_from, "d-m-Y") . ' hingga ' . date_format($date_to, "d-m-Y");

        return Excel::download(new OutgoingExport($sortCustomer), $formatFileName . '.xlsx');
    }

    public function exportOutgoingBrand(Request $request)
    {
        $brand = Brand::find($request->brandOutgoing);
        $date_from = Carbon::parse($request->startRange)->startOfDay();
        $date_to = Carbon::parse($request->endRange)->endOfDay();

        // $sortBrand = Outgoing::all()->where('brand_id', $request->brandOutgoing)->whereBetween('created_at', [$date_from, $date_to]); // versi lama pake created at
        $sortBrand = Outgoing::all()->where('brand_id', $request->brandOutgoing)->whereBetween('depart_date', [$date_from, $date_to]);
        $formatFileName = 'DataBarangKeluar Brand ' . $brand->brand_name . ' ' . date_format($date_from, "d-m-Y") . ' hingga ' . date_format($date_to, "d-m-Y");

        return Excel::download(new OutgoingExport($sortBrand),  $formatFileName . '.xlsx');
    }

    public function exportOutgoingItem(Request $request)
    {
        $item = Item::find($request->itemOutgoing);
        $date_from = Carbon::parse($request->startRange)->startOfDay();
        $date_to = Carbon::parse($request->endRange)->endOfDay();

        // $sortItem = Outgoing::all()->where('item_id', $request->itemOutgoing)->whereBetween('created_at', [$date_from, $date_to]); // versi lama pake created at
        $sortItem = Outgoing::all()->where('item_id', $request->itemOutgoing)->whereBetween('depart_date', [$date_from, $date_to]);
        $formatFileName = 'DataBarangKeluar Item ' . $item->item_name . ' ' . date_format($date_from, "d-m-Y") . ' hingga ' . date_format($date_to, "d-m-Y");
        return Excel::download(new OutgoingExport($sortItem),  $formatFileName . '.xlsx');
    }

    public function deleteItemOutgoing($id)
    {
        try {
            $decrypted = decrypt($id);
        } catch (DecryptException $e) {
            abort(403);
        }

        $outgoingInfo = Outgoing::where('id', $decrypted)->first();
        $itemInfo = Item::where('item_id', $outgoingInfo->item_id)->first();

        $newValue = $itemInfo->stocks + $outgoingInfo->stock_taken;

        Item::where('item_id', $outgoingInfo->item_id)->update([ //kurangin stock sesuai jumlah stock dalam incoming ini
            'stocks' => $newValue
        ]);

        Storage::delete('public/' . $outgoingInfo->item_pictures);
        $outgoingInfo->delete();
        // session()->flash('suksesDeleteIncoming', 'Sukses hapus data kedatangan barang ' . $itemInfo->item_name . ' (' + intval($itemInfo->stocks) . ') stock');
        session()->flash('suksesDeleteOutgoing', 'Sukses hapus data keluar barang ' . $itemInfo->item_name);
        return redirect()->back();
    }

    public function updateOutgoingData(Request $request)
    {

        if ($request->file('outgoingItemImage') || $request->outgoingEdit) {
            $outgoingInfo = Outgoing::where('id', $request->outgoingIdHidden)->first();

            // ini buat update valuenya
            $itemInfo = Item::where('item_id', $outgoingInfo->item_id)->first();


            $file = $request->file('outgoingItemImage');

            // validasi data buat mastiin gambar nggak null
            if ($file != null) {
                $request->validate([
                    'outgoingItemImage' => 'mimes:jpeg,png,jpg|max:10240',

                ], [
                    'outgoingItemImage.mimes' => 'Tipe foto yang diterima hanya jpeg, jpg, dan png',
                    'outgoingItemImage.max' => 'Ukuran foto harus dibawah 10 MB',
                ]);
            }

            // buat update image
            if ($file != null) {
                // dd('msk');

                // $imageName = time() . '.' . $file->getClientOriginalExtension();
                // Storage::putFileAs('public/outgoingItemImage', $file, $imageName);
                // $imageName = 'outgoingItemImage/' . $imageName;

                $imageName = time() . '.' . $file->getClientOriginalExtension();
                $destination = public_path('storage\outgoingItemImage') . '\\' . $imageName;

                $data = getimagesize($file);
                $width = $data[0];
                $height = $data[1];
                // dd($width . ' ' . $height);
                // image resizing with "Image Intervention"
                if ($width > $height) {
                    $resize_image = Image::make($file->getRealPath())->resize(
                        1920,
                        1080
                    )->save($destination);
                } else {
                    $resize_image = Image::make($file->getRealPath())->resize(
                        1080,
                        1920
                    )->save($destination);
                }
                // $resize_image->save($destination);
                // image resizing with "Image Intervention" end line of code
                $imageName = 'outgoingItemImage/' . $imageName;
                //

                Storage::delete('public/' . $outgoingInfo->item_pictures);

                Outgoing::where('id', $request->outgoingIdHidden)->update([
                    'item_pictures' => $imageName,
                ]);


                $file = $request->file('outgoingItemImage');
            } else {
                // dd("lha");
                Outgoing::where('id', $request->outgoingIdHidden)->update([
                    'item_pictures' => $outgoingInfo->item_pictures,
                ]);
            }

            // buat VALUE
            if ($request->outgoingEdit != null) {

                // ini buat update data stocks yang di itemnya
                $newValue = $itemInfo->stocks + $outgoingInfo->stock_taken - $request->outgoingEdit;
                // ini buat update data stock_now yang di outgoingnya
                $newStockNow = $outgoingInfo->stock_now + $outgoingInfo->stock_taken - $request->outgoingEdit;

                if ($newValue < 0) {
                    session()->flash('newValueMinus', 'Gagal karena stock akan kurang dari 0 (minus)');
                    return redirect()->back();
                }

                Item::where('item_id', $outgoingInfo->item_id)->update([ //kurangin stock sesuai jumlah stock dalam incoming ini
                    'stocks' => $newValue
                ]);

                Outgoing::where('id', $request->outgoingIdHidden)->update([
                    'stock_taken' => $request->outgoingEdit,
                    'stock_now' => $newStockNow
                ]);

                session()->flash('suksesUpdateOutgoing', 'Sukses update data keluar barang ' . $itemInfo->item_name);
            } else {
                $request->session()->flash('suksesUpdateOutgoing', 'Sukses update data keluar barang ' . $itemInfo->item_name);
            }
        } else {
            $request->session()->flash('noData_editItem', 'tidak ada');
        }
        return redirect()->back();
    }
}
