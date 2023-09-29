<?php

namespace App\Http\Controllers;

use App\Exports\PalletHistoryExport;
use App\Exports\PalletReportExport;
use App\Models\Brand;
use App\Models\Customer;
use App\Models\Item;
use App\Models\Pallet;
use App\Models\PalletHistory;
use Carbon\Carbon;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class PalletController extends Controller
{
    public function manage_pallet_page()
    {
        $user = Auth::user();

        // $pallet = Pallet::all();
        // $item = Item::all();

        $pallet = DB::table('pallets')
            ->join('items', 'pallets.item_id', '=', 'items.item_id')
            ->select('pallets.*', 'items.item_name')->get();
        // dd($pallet);

        $item = DB::table('items')
            ->join('customer', 'items.customer_id', '=', 'customer.customer_id')
            ->select('items.item_name', 'items.item_id')->get();

        // if ($user->level == 'admin') {
        //     $pallet = DB::table('pallets')
        //         ->join('items', 'pallets.item_id', '=', 'items.id')
        //         ->select('pallets.*', 'items.item_name')->get();
        //     // dd($pallet);

        //     $item = DB::table('items')
        //         ->join('customer', 'items.customer_id', '=', 'customer.id')
        //         ->select('items.item_name', 'items.item_id', 'items.id')->get();
        // } else {
        //     $pallet = DB::table('pallets')
        //         ->join('items', 'pallets.item_id', '=', 'items.id')
        //         ->join('customer', 'items.customer_id', '=', 'customer.id')
        //         ->join('user_accesses', 'user_accesses.customer_id', '=', 'items.customer_id')
        //         ->select('pallets.*', 'items.item_name', 'customer.id as customer_id', 'customer.customer_name', 'user_accesses.user_id')
        //         ->where('user_id', $user->id)->get();
        //     // dd($pallet);

        //     $item = DB::table('items')
        //         ->join('customer', 'items.customer_id', '=', 'customer.id')
        //         ->join('user_accesses', 'user_accesses.customer_id', '=', 'items.customer_id')
        //         ->select('items.item_name', 'items.item_id', 'items.id')
        //         ->where('user_id', $user->id)->get();
        // }

        return view('manage_views.managePallet', compact('pallet', 'item'));
    }

    // public function add_pallet(Request $request)
    // {
    //     $itemInfo = Item::where('item_id', $request->itemidforpallet)->first();
    //     $totalInPalletCurrently = Pallet::where('item_id', $request->itemidforpallet)->sum('stock'); //INI BISA DAPET TOTALNYA

    //     // stok total yg di palet pada suatu item tidak boleh melebihi stok item di tabel items
    //     $availableStock = $itemInfo->stocks - $totalInPalletCurrently;

    //     // dd($availableStock);
    //     if ($availableStock < $request->palletStock) {
    //         session()->flash('gagalMasukPaletVALUE', 'stok ke palet melebihi stok barang');
    //         return redirect()->back();
    //     }

    //     $request->validate([
    //         'palletDesc' => 'min:1|max:50',
    //         'bin' => 'max:10'
    //     ], [
    //         'palletDesc.min' => 'Deskripsi minimal 1 karakter',
    //         'palletDesc.max' => 'Deskripsi maksimal 50 karakter',
    //         'bin.max' => 'BIN maksimal 10 karakter',
    //     ]);

    //     // memasukkan data ke tabel palet
    //     $pallet = new Pallet();
    //     $pallet->item_id = $request->itemidforpallet;
    //     $pallet->stock = $request->palletStock;
    //     $pallet->bin = $request->bin;
    //     $pallet->description = $request->palletDesc;

    //     $pallet->save();


    //     // memasukkan data ke tabel sejarah palet
    //     $history = new PalletHistory();
    //     // $history->item_id = $request->itemidforpallet;
    //     $history->item_id = $itemInfo->item_id;
    //     $history->stock = $request->palletStock;
    //     $history->bin = $request->bin;
    //     $history->status = 'DALAM INVENTORY';
    //     $history->user = $request->userIdHidden;

    //     $history->save();

    //     session()->flash('suksesMasukPaletVALUE', 'Stok barang dimasukkan ke palet');

    //     return redirect()->back();
    // }

    // public function reduce_pallet_stock(Request $request)
    // {
    //     // dd($request->palletIdHidden);
    //     $palletInfo = Pallet::where('id', $request->palletIdHidden)->first();
    //     // dd($palletInfo);
    //     // $itemInfo = Item::where('item_id',$palletInfo->item_id)->first();

    //     $itemInfo = DB::table('pallets')
    //         ->join('items', 'items.item_id', '=', 'pallets.item_id')
    //         ->select('items.*')->where('pallets.id', $request->palletIdHidden)->first();

    //     // dd($itemInfo);
    //     $id = Auth::user()->id;

    //     if ($palletInfo->stock < $request->palletStockOut) {
    //         session()->flash('gagalStokPalletKeluar', 'stok yang ingin dikeluarkan lebih besar dari stok di palet');
    //         return redirect()->back();
    //     } else if ($palletInfo->stock == $request->palletStockOut) { //ini kalau keluar semua stoknya
    //         $palletInfo->delete();

    //         // memasukkan data ke tabel sejarah palet
    //         $history = new PalletHistory();
    //         $history->item_id = $itemInfo->item_id;
    //         $history->stock = $palletInfo->stock;
    //         $history->bin = $palletInfo->bin;
    //         $history->status = 'KELUAR';
    //         $history->user = $id;

    //         $history->save();

    //         session()->flash('suksesPaletKeluar', 'Barang Berhasil Dikeluarkan dari Palet');
    //         return redirect()->back();
    //     } else if ($palletInfo->stock > $request->palletStockOut) { //ini kalau keluar sebagian stoknya
    //         $newValue = $palletInfo->stock - $request->palletStockOut;
    //         // memasukkan data ke tabel sejarah palet
    //         $history = new PalletHistory();
    //         // dd($itemInfo->item_id);
    //         $history->item_id = $itemInfo->item_id;
    //         // dd('s');
    //         $history->stock = $newValue;
    //         $history->bin = $palletInfo->bin;
    //         $history->status = 'KELUAR SEBAGIAN ' . '(' . (string)$request->palletStockOut . ')';
    //         $history->user = $id;

    //         Pallet::where('id', $request->palletIdHidden)->update([
    //             'stock' => $newValue
    //         ]);

    //         $history->save();

    //         session()->flash('suksesPaletKeluar2', 'Barang Berhasil Dikeluarkan Sebanyak ' . $request->palletStockOut);
    //         return redirect()->back();
    //     }
    // }

    // public function remove_pallet($id)
    // {
    //     try {
    //         $decrypted = decrypt($id);
    //     } catch (DecryptException $e) {
    //         abort(403);
    //     }
    //     $palletInfo = Pallet::where('id', $decrypted)->first();
    //     $id = Auth::user()->id;

    //     // dd($decrypted);
    //     // dd($palletInfo->item_id);


    //     // $palletInfo = Pallet::where('id', $decrypted)->first();

    //     $palletInfo->delete();

    //     // memasukkan data ke tabel sejarah palet
    //     $history = new PalletHistory();
    //     $history->item_id = $palletInfo->item_id;
    //     $history->stock = $palletInfo->stock;
    //     $history->bin = $palletInfo->bin;
    //     $history->status = 'KELUAR';
    //     $history->user = $id;

    //     $history->save();

    //     session()->flash('suksesPaletKeluar', 'Barang Berhasil Dikeluarkan dari Palet');
    //     return redirect()->back();
    // }

    public function manage_pallet_history_page()
    {
        session()->forget('deleteFilterButton');

        $user = Auth::user();
        $item = Item::all();
        $palletHistory = DB::table('pallet_histories')
            ->join('items', 'pallet_histories.item_id', '=', 'items.item_id')
            ->select('pallet_histories.*', 'items.item_name')->get();

        // if ($user->level == 'admin') {
        //     $item = Item::all();
        //     // $palletHistory = PalletHistory::all();
        //     $palletHistory = DB::table('pallet_histories')
        //         ->join('items', 'pallet_histories.item_id', '=', 'items.item_id') //join('tabel yang mau di tambahin', 'tabel utama.value yang mau dicocokin', '=', 'tabel yang ditambahin.value yang mau dicocokin')
        //         ->join('users', 'pallet_histories.user', '=', 'users.id') //bagian join bisa dilakuin berkali kali
        //         ->select('pallet_histories.*', 'items.item_name', 'users.name')->get(); //jgn lupa manggil semua tabel utamanya terus ditambah lagi kolom yang diinginkan
        //     // dd($palletHistory);
        // } else {
        //     $item = DB::table('items')
        //         ->join('customer', 'items.customer_id', '=', 'customer.id')
        //         ->join('user_accesses', 'user_accesses.customer_id', '=', 'items.customer_id')
        //         ->select('items.item_name', 'items.item_id', 'items.id')
        //         ->where('user_id', $user->id)->get();

        //     $palletHistory = DB::table('pallet_histories')
        //         ->join('items', 'pallet_histories.item_id', '=', 'items.item_id')
        //         ->join('customer', 'items.customer_id', '=', 'customer.id')
        //         ->join('user_accesses', 'user_accesses.customer_id', '=', 'items.customer_id')
        //         ->join('users', 'pallet_histories.user', '=', 'users.id')
        //         ->select('pallet_histories.*', 'items.item_name', 'users.name')
        //         ->where('user_id', $user->id)->get();
        // }

        return view('history_views.palletHistory', compact('palletHistory', 'item'));
    }

    public function exportPalletItemHistory(Request $request)
    {

        // dd($request->itemPalletHistoryExport);
        $item = Item::where('item_id', $request->itemPalletHistoryExport)->first();

        $sortPalletItemHistory = DB::table('pallet_histories')
            ->join('items', 'items.item_id', '=', 'pallet_histories.item_id')
            ->select('pallet_histories.*', 'items.item_name')
            ->where('pallet_histories.item_id', $request->itemPalletHistoryExport)->get();
        // dd($sortPalletItemHistory);

        // $sortPalletItemHistory = PalletHistory::all()->where('item_id', $request->itemPalletHistoryExport);

        return Excel::download(new PalletHistoryExport($sortPalletItemHistory), 'History Palet milik item ' . $item->item_name . '.xlsx');
    }

    public function exportPalletHistoryByDate(Request $request)
    {
        $date_from = Carbon::parse($request->startRange)->startOfDay();
        $date_to = Carbon::parse($request->endRange)->endOfDay();

        $user = Auth::user();

        $sortHistoryDate = DB::table('pallet_histories')
            ->join('items', 'items.item_id', '=', 'pallet_histories.item_id')
            ->select('pallet_histories.*', 'items.item_name')
            ->whereBetween('pallet_histories.user_date', [$date_from, $date_to])->get();

        // if ($user->level != 'admin') {
        //     $sortHistoryDate = DB::table('pallet_histories')
        //         ->join('items', 'items.item_id', '=', 'pallet_histories.item_id')
        //         ->join('users', 'users.id', '=', 'pallet_histories.user')
        //         ->join('user_accesses', 'user_accesses.customer_id', '=', 'items.customer_id')
        //         ->select('pallet_histories.*', 'items.item_name', 'users.name')
        //         ->where('user_id', $user->id)
        //         ->whereBetween('pallet_histories.created_at', [$date_from, $date_to])->get();
        //     // dd($sortHistoryDate);
        // } else {
        //     $sortHistoryDate = DB::table('pallet_histories')
        //         ->join('items', 'items.item_id', '=', 'pallet_histories.item_id')
        //         ->join('users', 'users.id', '=', 'pallet_histories.user')
        //         ->select('pallet_histories.*', 'items.item_name', 'users.name')
        //         ->whereBetween('pallet_histories.created_at', [$date_from, $date_to])->get();
        // }

        $formatFileName = 'DataHistoryPalet ' . date_format($date_from, "d-m-Y") . ' hingga ' . date_format($date_to, "d-m-Y");

        return Excel::download(new PalletHistoryExport($sortHistoryDate), $formatFileName . '.xlsx');
    }

    public function filterPalletHistoryDate(Request $request)
    {
        $date_from = Carbon::parse($request->startRange)->startOfDay();
        $date_to = Carbon::parse($request->endRange)->endOfDay();
        // dd($date_from . $date_to);

        $user = Auth::user();

        $item = Item::all();
        $palletHistory = DB::table('pallet_histories')
            ->join('items', 'pallet_histories.item_id', '=', 'items.item_id')
            ->select('pallet_histories.*', 'items.item_name')
            ->whereBetween('pallet_histories.user_date', [$date_from, $date_to])->get();

        // if ($user->level == 'admin') {
        //     $item = Item::all();
        //     $palletHistory = DB::table('pallet_histories')
        //         ->join('items', 'pallet_histories.item_id', '=', 'items.item_id')
        //         ->join('users', 'pallet_histories.user', '=', 'users.id')
        //         ->select('pallet_histories.*', 'items.item_name', 'users.name')
        //         ->whereBetween('pallet_histories.created_at', [$date_from, $date_to])->get();
        // } else {
        //     $item = DB::table('items')
        //         ->join('customer', 'items.customer_id', '=', 'customer.id')
        //         ->join('user_accesses', 'user_accesses.customer_id', '=', 'items.customer_id')
        //         ->select('items.item_name', 'items.item_id', 'items.id')
        //         ->where('user_id', $user->id)->get();

        //     $palletHistory = DB::table('pallet_histories')
        //         ->join('items', 'pallet_histories.item_id', '=', 'items.item_id')
        //         ->join('customer', 'items.customer_id', '=', 'customer.id')
        //         ->join('user_accesses', 'user_accesses.customer_id', '=', 'items.customer_id')
        //         ->join('users', 'pallet_histories.user', '=', 'users.id')
        //         ->select('pallet_histories.*', 'items.item_name', 'users.name')
        //         ->where('user_id', $user->id)
        //         ->whereBetween('pallet_histories.created_at', [$date_from, $date_to])
        //         ->get();
        // }
        $request->session()->flash('deleteFilterButton', 'yea');

        return view('history_views.palletHistory', compact('palletHistory', 'item'));
    }

    public function pallet_report_page()
    {
        // return view('inPallet');
        $inpallet = DB::table('inpallet')
            ->join('items', 'inpallet.item_id', '=', 'items.item_id')
            ->join('customer', 'items.customer_id', '=', 'customer.customer_id')
            ->join('brand', 'items.brand_id', '=', 'brand.brand_id')
            ->select('inpallet.*', 'items.item_name', 'customer.customer_name', 'brand.brand_name')->get();
        // dd($pallet);

        $item = DB::table('items')
            ->join('customer', 'items.customer_id', '=', 'customer.customer_id')
            ->select('items.item_name', 'items.item_id')->get();

        $brand = Brand::all();
        $customer = Customer::all();


        return view('report_views.palletReport', compact('inpallet', 'item', 'customer', 'brand'));
        // return view('report_views.palletReport');
    }

    public function exportPalletReportCustomer(Request $request)
    {
        $customer = Customer::find($request->customerIdPalletReport);

        $sortAll = DB::table('inpallet')
            ->join('items', 'inpallet.item_id', '=', 'items.item_id')
            ->join('customer', 'items.customer_id', '=', 'customer.customer_id')
            ->join('brand', 'items.brand_id', '=', 'brand.brand_id')
            ->select('inpallet.*', 'customer.customer_name', 'brand.brand_name', 'items.item_name', 'items.item_id', 'brand.brand_id')
            ->where('items.customer_id', $request->customerIdPalletReport)->get();

        $formatFileName = 'Laporan Stok by palet Customer ' . $customer->customer_name;
        return Excel::download(new PalletReportExport($sortAll), $formatFileName . '.xlsx');
    }

    public function exportPalletReportBrand(Request $request)
    {
        $brand = Brand::find($request->brandIdPalletReport);

        $sortAll = DB::table('inpallet')
            ->join('items', 'inpallet.item_id', '=', 'items.item_id')
            ->join('customer', 'items.customer_id', '=', 'customer.customer_id')
            ->join('brand', 'items.brand_id', '=', 'brand.brand_id')
            ->select('inpallet.*', 'customer.customer_name', 'brand.brand_name', 'items.item_name', 'items.item_id', 'brand.brand_id')
            ->where('items.brand_id', $request->brandIdPalletReport)->get();

        $formatFileName = 'Laporan Stok by palet Brand ' . $brand->brand_name;
        return Excel::download(new PalletReportExport($sortAll), $formatFileName . '.xlsx');
    }

    public function exportPalletReportItem(Request $request)
    {
        $item = Item::find($request->itemIdPalletReport);

        $sortAll = DB::table('inpallet')
            ->join('items', 'inpallet.item_id', '=', 'items.item_id')
            ->join('customer', 'items.customer_id', '=', 'customer.customer_id')
            ->join('brand', 'items.brand_id', '=', 'brand.brand_id')
            ->select('inpallet.*', 'customer.customer_name', 'brand.brand_name', 'items.item_name', 'items.item_id', 'brand.brand_id')
            ->where('inpallet.item_id', $request->itemIdPalletReport)->get();

        $formatFileName = 'Laporan Stok by palet Barang ' . $item->item_name;
        return Excel::download(new PalletReportExport($sortAll), $formatFileName . '.xlsx');
    }

    public function exportPalletReportDate(Request $request)
    {
        $date_from = Carbon::parse($request->startRange)->startOfDay();
        $date_to = Carbon::parse($request->endRange)->endOfDay();

        $sortAll = DB::table('inpallet')
            ->join('items', 'inpallet.item_id', '=', 'items.item_id')
            ->join('customer', 'items.customer_id', '=', 'customer.customer_id')
            ->join('brand', 'items.brand_id', '=', 'brand.brand_id')
            ->select('inpallet.*', 'customer.customer_name', 'brand.brand_name', 'items.item_name', 'items.item_id', 'brand.brand_id')
            ->whereBetween('user_date', [$date_from, $date_to])->get();

        $formatFileName = 'Laporan Stok by palet ALL ' . date_format($date_from, "d-m-Y") . ' hingga ' . date_format($date_to, "d-m-Y");
        return Excel::download(new PalletReportExport($sortAll), $formatFileName . '.xlsx');
    }
}
