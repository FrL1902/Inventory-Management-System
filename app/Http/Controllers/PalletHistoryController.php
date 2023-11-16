<?php

namespace App\Http\Controllers;

use App\Exports\PalletHistoryExport;
use App\Models\Item;
use App\Models\UserAccess;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class PalletHistoryController extends Controller
{
    public function manage_pallet_history_page()
    {
        session()->forget('deleteFilterButton');

        $user = Auth::user();

        if ($user->level == 'admin') {
            $item = DB::table('items')
                ->join('customer', 'items.customer_id', '=', 'customer.customer_id')
                ->select('items.item_name', 'items.item_id')->get();

            $palletHistory = DB::table('pallet_histories')
                ->join('items', 'pallet_histories.item_id', '=', 'items.item_id')
                ->select('pallet_histories.*', 'items.item_name')->get();
        } else {
            $item = DB::table('items')
                ->join('customer', 'items.customer_id', '=', 'customer.customer_id')
                ->join('user_accesses', 'user_accesses.customer_id', '=', 'items.customer_id')
                ->select('items.item_name', 'items.item_id')
                ->where('user_id', $user->name)->get();

            $palletHistory = DB::table('pallet_histories')
                ->join('items', 'pallet_histories.item_id', '=', 'items.item_id')
                ->join('user_accesses', 'user_accesses.customer_id', '=', 'items.customer_id')
                ->select('pallet_histories.*', 'items.item_name')
                ->where('user_id', $user->name)->get();
        }

        return view('history_views.palletHistory', compact('palletHistory', 'item'));
    }

    public function exportPalletItemHistory(Request $request)
    {
        $item = Item::where('item_id', $request->itemPalletHistoryExport)->first();

        $sortPalletItemHistory = DB::table('pallet_histories')
            ->join('items', 'items.item_id', '=', 'pallet_histories.item_id')
            ->select('pallet_histories.*', 'items.item_name')
            ->where('pallet_histories.item_id', $request->itemPalletHistoryExport)->get();

        return Excel::download(new PalletHistoryExport($sortPalletItemHistory), 'History Palet milik item ' . $item->item_name . '.xlsx');
    }

    public function exportPalletHistoryByDate(Request $request)
    {
        $date_from = Carbon::parse($request->startRange)->startOfDay();
        $date_to = Carbon::parse($request->endRange)->endOfDay();

        $user = Auth::user();

        if ($user->level == 'admin') {
            $sortHistoryDate = DB::table('pallet_histories')
                ->join('items', 'items.item_id', '=', 'pallet_histories.item_id')
                ->select('pallet_histories.*', 'items.item_name')
                ->whereBetween('pallet_histories.user_date', [$date_from, $date_to])->get();
        } else {
            $sortHistoryDate = DB::table('pallet_histories')
                ->join('items', 'pallet_histories.item_id', '=', 'items.item_id')
                ->join('user_accesses', 'user_accesses.customer_id', '=', 'items.customer_id')
                ->select('pallet_histories.*', 'items.item_name')
                ->whereBetween('pallet_histories.user_date', [$date_from, $date_to])
                ->where('user_id', $user->name)->get();
        }

        $formatFileName = 'DataHistoryPalet ' . date_format($date_from, "d-m-Y") . ' hingga ' . date_format($date_to, "d-m-Y");

        return Excel::download(new PalletHistoryExport($sortHistoryDate), $formatFileName . '.xlsx');
    }

    public function filterPalletHistoryDate(Request $request)
    {
        $date_from = Carbon::parse($request->startRange)->startOfDay();
        $date_to = Carbon::parse($request->endRange)->endOfDay();

        $user = Auth::user();

        if ($user->level == 'admin') {
            $item = Item::all();

            $palletHistory = DB::table('pallet_histories')
                ->join('items', 'pallet_histories.item_id', '=', 'items.item_id')
                ->select('pallet_histories.*', 'items.item_name')
                ->whereBetween('pallet_histories.user_date', [$date_from, $date_to])->get();
        } else {
            $item = DB::table('items')
                ->join('customer', 'items.customer_id', '=', 'customer.customer_id')
                ->join('user_accesses', 'user_accesses.customer_id', '=', 'items.customer_id')
                ->select('items.item_name', 'items.item_id')
                ->where('user_id', $user->name)->get();

            $palletHistory = DB::table('pallet_histories')
                ->join('items', 'pallet_histories.item_id', '=', 'items.item_id')
                ->join('user_accesses', 'user_accesses.customer_id', '=', 'items.customer_id')
                ->select('pallet_histories.*', 'items.item_name')
                ->whereBetween('pallet_histories.user_date', [$date_from, $date_to])
                ->where('user_id', $user->name)->get();
        }

        $request->session()->flash('deleteFilterButton', 'yea');

        return view('history_views.palletHistory', compact('palletHistory', 'item'));
    }
}
