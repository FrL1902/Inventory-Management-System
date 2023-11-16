<?php

namespace App\Http\Controllers;

use App\Exports\PalletHistoryExport;
use App\Exports\PalletReportExport;
use App\Models\Brand;
use App\Models\Customer;
use App\Models\Item;
use App\Models\Pallet;
use App\Models\PalletHistory;
use App\Models\UserAccess;
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


    public function manage_pallet_history_page()
    {
        session()->forget('deleteFilterButton');

        $user = Auth::user();
        $cekAll = UserAccess::where('user_id', 'LIKE', $user->name)->first();
        if ($user->level == "customer" && $cekAll->customer_id != 0) {
            // $history = StockHistory::all();
            $palletHistory = DB::table('pallet_histories')
                ->join('items', 'pallet_histories.item_id', '=', 'items.item_id')
                ->join('user_accesses', 'user_accesses.customer_id', '=', 'items.customer_id')
                ->select('pallet_histories.*', 'items.item_name')
                ->where('items.customer_id', $cekAll->customer_id)->get();
            $item = Item::all()->where('customer_id', $cekAll->customer_id);

            return view('history_views.palletHistory', compact('palletHistory', 'item'));
        }

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
        $cekAll = UserAccess::where('user_id', 'LIKE', $user->name)->first();
        if ($user->level == "customer" && $cekAll->customer_id != 0) {
            // $history = StockHistory::all();
            $sortHistoryDate = DB::table('pallet_histories')
                ->join('items', 'pallet_histories.item_id', '=', 'items.item_id')
                ->join('user_accesses', 'user_accesses.customer_id', '=', 'items.customer_id')
                ->select('pallet_histories.*', 'items.item_name')
                ->where('items.customer_id', $cekAll->customer_id)
                ->whereBetween('pallet_histories.user_date', [$date_from, $date_to])->get();

            $formatFileName = 'DataHistoryPalet ' . date_format($date_from, "d-m-Y") . ' hingga ' . date_format($date_to, "d-m-Y");

            return Excel::download(new PalletHistoryExport($sortHistoryDate), $formatFileName . '.xlsx');
        }

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
        $cekAll = UserAccess::where('user_id', 'LIKE', $user->name)->first();
        if ($user->level == "customer" && $cekAll->customer_id != 0) {
            // $history = StockHistory::all();
            $palletHistory = DB::table('pallet_histories')
                ->join('items', 'pallet_histories.item_id', '=', 'items.item_id')
                ->join('user_accesses', 'user_accesses.customer_id', '=', 'items.customer_id')
                ->select('pallet_histories.*', 'items.item_name')
                ->where('items.customer_id', $cekAll->customer_id)
                ->whereBetween('pallet_histories.user_date', [$date_from, $date_to])->get();
            $item = Item::all()->where('customer_id', $cekAll->customer_id);

            $request->session()->flash('deleteFilterButton', 'yea');

            return view('history_views.palletHistory', compact('palletHistory', 'item'));
        }

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
        $user = Auth::user();

        if ($user->level == 'user') {
            $item = DB::table('items')
                ->join('customer', 'items.customer_id', '=', 'customer.customer_id')
                ->join('user_accesses', 'user_accesses.customer_id', '=', 'items.customer_id')
                ->select('items.item_name', 'items.item_id')
                ->where('user_id', $user->name)->get();

            $customer = DB::table('customer')
                ->join('user_accesses', 'user_accesses.customer_id', '=', 'customer.customer_id')
                ->select('customer.customer_name', 'customer.customer_id')
                ->where('user_id', $user->name)->get();

            $brand =  DB::table('brand')
                ->join('user_accesses', 'user_accesses.customer_id', '=', 'brand.customer_id')
                ->select('brand.brand_id', 'brand.brand_name')
                ->where('user_id', $user->name)->get();

            $inpallet = DB::table('inpallet')
                ->join('items', 'inpallet.item_id', '=', 'items.item_id')
                ->join('customer', 'items.customer_id', '=', 'customer.customer_id')
                ->join('brand', 'items.brand_id', '=', 'brand.brand_id')
                ->join('user_accesses', 'items.customer_id', '=', 'user_accesses.customer_id')
                ->select('inpallet.bin', 'inpallet.item_id', 'items.item_name', 'items.item_pictures', 'customer.customer_name', 'brand.brand_name', DB::raw("SUM(inpallet.stock) as jumlah_stok"), DB::raw("MAX(inpallet.user_date) as tanggal"))
                ->groupBy('inpallet.item_id', 'inpallet.bin', 'items.item_name', 'customer.customer_name', 'brand.brand_name', 'items.item_pictures')
                ->where('user_id', $user->name)
                ->get();
        } else {
            $customer = Customer::all();
            $brand = Brand::all();

            $item = DB::table('items')
                ->join('customer', 'items.customer_id', '=', 'customer.customer_id')
                ->select('items.item_name', 'items.item_id')->get();

            $inpallet = DB::table('inpallet')
                ->join('items', 'inpallet.item_id', '=', 'items.item_id')
                ->join('customer', 'items.customer_id', '=', 'customer.customer_id')
                ->join('brand', 'items.brand_id', '=', 'brand.brand_id')
                ->select('inpallet.bin', 'inpallet.item_id', 'items.item_name', 'items.item_pictures', 'customer.customer_name', 'brand.brand_name', DB::raw("SUM(inpallet.stock) as jumlah_stok"), DB::raw("MAX(inpallet.user_date) as tanggal"))
                ->groupBy('inpallet.item_id', 'inpallet.bin', 'items.item_name', 'customer.customer_name', 'brand.brand_name', 'items.item_pictures')
                ->get();
        }

        return view('report_views.palletReport', compact('inpallet', 'item', 'customer', 'brand'));
    }

    public function exportPalletReportCustomer(Request $request)
    {
        $customer = Customer::find($request->customerIdPalletReport);

        // $sortAll = DB::table('inpallet')
        //     ->join('items', 'inpallet.item_id', '=', 'items.item_id')
        //     ->join('customer', 'items.customer_id', '=', 'customer.customer_id')
        //     ->join('brand', 'items.brand_id', '=', 'brand.brand_id')
        //     ->select('inpallet.*', 'customer.customer_name', 'brand.brand_name', 'items.item_name', 'items.item_id', 'brand.brand_id')
        //     ->where('items.customer_id', $request->customerIdPalletReport)->get();

        $sortAll = DB::table('inpallet')
            ->join('items', 'inpallet.item_id', '=', 'items.item_id')
            ->join('customer', 'items.customer_id', '=', 'customer.customer_id')
            ->join('brand', 'items.brand_id', '=', 'brand.brand_id')
            ->select('inpallet.bin', 'inpallet.item_id', 'items.item_name', 'items.item_pictures', 'customer.customer_name', 'brand.brand_name', DB::raw("SUM(inpallet.stock) as jumlah_stok"), DB::raw("MAX(inpallet.user_date) as tanggal"))
            ->groupBy('inpallet.item_id', 'inpallet.bin', 'items.item_name', 'customer.customer_name', 'brand.brand_name', 'items.item_pictures')
            ->where('items.customer_id', $request->customerIdPalletReport)->get();

        $formatFileName = 'Laporan Stok by palet Customer ' . $customer->customer_name;
        return Excel::download(new PalletReportExport($sortAll), $formatFileName . '.xlsx');
    }

    public function exportPalletReportBrand(Request $request)
    {
        $brand = Brand::find($request->brandIdPalletReport);

        // $sortAll = DB::table('inpallet')
        //     ->join('items', 'inpallet.item_id', '=', 'items.item_id')
        //     ->join('customer', 'items.customer_id', '=', 'customer.customer_id')
        //     ->join('brand', 'items.brand_id', '=', 'brand.brand_id')
        //     ->select('inpallet.*', 'customer.customer_name', 'brand.brand_name', 'items.item_name', 'items.item_id', 'brand.brand_id')
        //     ->where('items.brand_id', $request->brandIdPalletReport)->get();

        $sortAll = DB::table('inpallet')
            ->join('items', 'inpallet.item_id', '=', 'items.item_id')
            ->join('customer', 'items.customer_id', '=', 'customer.customer_id')
            ->join('brand', 'items.brand_id', '=', 'brand.brand_id')
            ->select('inpallet.bin', 'inpallet.item_id', 'items.item_name', 'items.item_pictures', 'customer.customer_name', 'brand.brand_name', DB::raw("SUM(inpallet.stock) as jumlah_stok"), DB::raw("MAX(inpallet.user_date) as tanggal"))
            ->groupBy('inpallet.item_id', 'inpallet.bin', 'items.item_name', 'customer.customer_name', 'brand.brand_name', 'items.item_pictures')
            ->where('items.brand_id', $request->brandIdPalletReport)->get();

        $formatFileName = 'Laporan Stok by palet Brand ' . $brand->brand_name;
        return Excel::download(new PalletReportExport($sortAll), $formatFileName . '.xlsx');
    }

    public function exportPalletReportItem(Request $request)
    {
        $item = Item::find($request->itemIdPalletReport);

        // $sortAll = DB::table('inpallet')
        //     ->join('items', 'inpallet.item_id', '=', 'items.item_id')
        //     ->join('customer', 'items.customer_id', '=', 'customer.customer_id')
        //     ->join('brand', 'items.brand_id', '=', 'brand.brand_id')
        //     ->select('inpallet.*', 'customer.customer_name', 'brand.brand_name', 'items.item_name', 'items.item_id', 'brand.brand_id')
        //     ->where('inpallet.item_id', $request->itemIdPalletReport)->get();

        $sortAll = DB::table('inpallet')
            ->join('items', 'inpallet.item_id', '=', 'items.item_id')
            ->join('customer', 'items.customer_id', '=', 'customer.customer_id')
            ->join('brand', 'items.brand_id', '=', 'brand.brand_id')
            ->select('inpallet.bin', 'inpallet.item_id', 'items.item_name', 'items.item_pictures', 'customer.customer_name', 'brand.brand_name', DB::raw("SUM(inpallet.stock) as jumlah_stok"), DB::raw("MAX(inpallet.user_date) as tanggal"))
            ->groupBy('inpallet.item_id', 'inpallet.bin', 'items.item_name', 'customer.customer_name', 'brand.brand_name', 'items.item_pictures')
            ->where('inpallet.item_id', $request->itemIdPalletReport)->get();

        $formatFileName = 'Laporan Stok by palet Barang ' . $item->item_name;
        return Excel::download(new PalletReportExport($sortAll), $formatFileName . '.xlsx');
    }

    public function exportPalletReportDate(Request $request)
    {
        $date_from = Carbon::parse($request->startRange)->startOfDay();
        $date_to = Carbon::parse($request->endRange)->endOfDay();

        $user = Auth::user();

        if ($user->level == 'admin') {
            $sortAll = DB::table('inpallet')
                ->join('items', 'inpallet.item_id', '=', 'items.item_id')
                ->join('customer', 'items.customer_id', '=', 'customer.customer_id')
                ->join('brand', 'items.brand_id', '=', 'brand.brand_id')
                ->select('inpallet.bin', 'inpallet.item_id', 'items.item_name', 'items.item_pictures', 'customer.customer_name', 'brand.brand_name', DB::raw("SUM(inpallet.stock) as jumlah_stok"), DB::raw("MAX(inpallet.user_date) as tanggal"))
                ->groupBy('inpallet.item_id', 'inpallet.bin', 'items.item_name', 'customer.customer_name', 'brand.brand_name', 'items.item_pictures')
                ->whereBetween('user_date', [$date_from, $date_to])->get();
        } else {
            $sortAll = DB::table('inpallet')
                ->join('items', 'inpallet.item_id', '=', 'items.item_id')
                ->join('customer', 'items.customer_id', '=', 'customer.customer_id')
                ->join('brand', 'items.brand_id', '=', 'brand.brand_id')
                ->join('user_accesses', 'items.customer_id', '=', 'user_accesses.customer_id')
                ->select('inpallet.bin', 'inpallet.item_id', 'items.item_name', 'items.item_pictures', 'customer.customer_name', 'brand.brand_name', DB::raw("SUM(inpallet.stock) as jumlah_stok"), DB::raw("MAX(inpallet.user_date) as tanggal"))
                ->groupBy('inpallet.item_id', 'inpallet.bin', 'items.item_name', 'customer.customer_name', 'brand.brand_name', 'items.item_pictures')
                ->whereBetween('user_date', [$date_from, $date_to])
                ->where('user_id', $user->name)
                ->get();
        }

        $formatFileName = 'Laporan Stok by palet ALL ' . date_format($date_from, "d-m-Y") . ' hingga ' . date_format($date_to, "d-m-Y");
        return Excel::download(new PalletReportExport($sortAll), $formatFileName . '.xlsx');
    }
}
