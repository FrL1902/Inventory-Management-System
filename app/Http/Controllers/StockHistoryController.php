<?php

namespace App\Http\Controllers;

use App\Exports\stockHistoryExport;
use App\Models\Item;
use App\Models\StockHistory;
use App\Models\UserAccess;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class StockHistoryController extends Controller
{
    public function filterHistoryDate(Request $request)
    {

        $date_from = Carbon::parse($request->startRange)->startOfDay();
        $date_to = Carbon::parse($request->endRange)->endOfDay();

        $user = Auth::user();
        // $cekAll = UserAccess::where('user_id', 'LIKE', $user->name)->first();
        // if ($user->level == "customer" && $cekAll->customer_id != 0) {
        //     // $history = StockHistory::all();
        //     $history = DB::table('stock_histories')
        //         ->join('items', 'stock_histories.item_id', '=', 'items.item_id')
        //         ->join('user_accesses', 'user_accesses.customer_id', '=', 'items.customer_id')
        //         ->select('stock_histories.*')
        //         ->where('items.customer_id', $cekAll->customer_id)->get();
        //     $item = Item::all()->where('customer_id', $cekAll->customer_id);

        //     return view('history_views.itemHistory', compact('history', 'item'));
        // }


        // $item = Item::all();

        // $history = StockHistory::all()->whereBetween('user_action_date', [$date_from, $date_to]);

        if ($user->level == 'admin') {
            $item = Item::all();
            $history = StockHistory::all()->whereBetween('user_action_date', [$date_from, $date_to]);
        } else {
            $item = DB::table('items')
                ->join('customer', 'items.customer_id', '=', 'customer.customer_id')
                ->join('user_accesses', 'user_accesses.customer_id', '=', 'items.customer_id')
                ->select('items.item_name', 'items.item_id')
                ->where('user_id', $user->name)->get();
            $history = DB::table('stock_histories')
                ->join('items', 'stock_histories.item_id', '=', 'items.item_id')
                ->join('customer', 'items.customer_id', '=', 'customer.customer_id')
                ->join('user_accesses', 'user_accesses.customer_id', '=', 'items.customer_id')
                ->select('stock_histories.*')
                ->where('user_id', $user->name)->whereBetween('stock_histories.user_action_date', [$date_from, $date_to])->get();
            // dd($sortHistoryDate);
        }


        $request->session()->flash('deleteFilterButton', 'yea');

        return view('history_views.itemHistory', compact('history', 'item'));
    }

    public function exportItemHistory(Request $request)
    {
        // dd($request->itemHistoryExport);
        $item = Item::where('item_id', $request->itemHistoryExport)->first();
        $sortHistory = StockHistory::all()->where('item_id', $request->itemHistoryExport);

        // return Excel::download(new stockHistoryExport($sortHistory), 'History milik item ' . $request->itemHistoryExport . '.xlsx');
        return Excel::download(new stockHistoryExport($sortHistory), 'History milik item ' . $item->item_name . '.xlsx');
    }

    public function exportHistoryByDate(Request  $request)
    {
        $date_from = Carbon::parse($request->startRange)->startOfDay();
        $date_to = Carbon::parse($request->endRange)->endOfDay();

        $user = Auth::user();

        // $sortHistoryDate = StockHistory::all()->whereBetween('user_action_date', [$date_from, $date_to]);
        // dd($sortHistoryDate);

        if ($user->level == 'admin') {
            $sortHistoryDate = StockHistory::all()->whereBetween('user_action_date', [$date_from, $date_to]);
        } else {
            $sortHistoryDate = DB::table('stock_histories')
                ->join('items', 'stock_histories.item_id', '=', 'items.item_id')
                ->join('customer', 'items.customer_id', '=', 'customer.customer_id')
                ->join('user_accesses', 'user_accesses.customer_id', '=', 'items.customer_id')
                ->select('stock_histories.*')
                ->where('user_id', $user->name)->whereBetween('stock_histories.user_action_date', [$date_from, $date_to])->get();
            // dd($sortHistoryDate);
        }

        $formatFileName = 'DataHistoryItem ' . date_format($date_from, "d-m-Y") . ' hingga ' . date_format($date_to, "d-m-Y");

        return Excel::download(new StockHistoryExport($sortHistoryDate), $formatFileName . '.xlsx');
    }
}
