<?php

namespace App\Http\Controllers;

use App\Exports\stockHistoryExport;
use App\Models\Item;
use App\Models\StockHistory;
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

        $history = StockHistory::all()->whereBetween('created_at', [$date_from, $date_to]);

        // if ($user->level != 'admin') {
        //     $history = DB::table('stock_histories')
        //         ->join('items', 'stock_histories.item_id', '=', 'items.item_id')
        //         ->join('customer', 'items.customer_id', '=', 'customer.id')
        //         ->join('user_accesses', 'user_accesses.customer_id', '=', 'items.customer_id')
        //         ->select('stock_histories.*')
        //         ->where('user_id', $user->id)->whereBetween('stock_histories.created_at', [$date_from, $date_to])->get();
        //     // dd($sortHistoryDate);
        // } else {
        //     $history = StockHistory::all()->whereBetween('created_at', [$date_from, $date_to]);
        // }


        $request->session()->flash('deleteFilterButton', 'yea');

        return view('itemHistory', compact('history'));
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

        $sortHistoryDate = StockHistory::all()->whereBetween('created_at', [$date_from, $date_to]);
        // dd($sortHistoryDate);

        // if ($user->level != 'admin') {
        //     $sortHistoryDate = DB::table('stock_histories')
        //         ->join('items', 'stock_histories.item_id', '=', 'items.item_id')
        //         ->join('customer', 'items.customer_id', '=', 'customer.id')
        //         ->join('user_accesses', 'user_accesses.customer_id', '=', 'items.customer_id')
        //         ->select('stock_histories.*')
        //         ->where('user_id', $user->id)->whereBetween('stock_histories.created_at', [$date_from, $date_to])->get();
        //     // dd($sortHistoryDate);
        // } else {
        //     $sortHistoryDate = StockHistory::all()->whereBetween('created_at', [$date_from, $date_to]);
        // }




        $formatFileName = 'DataHistoryItem ' . date_format($date_from, "d-m-Y") . ' hingga ' . date_format($date_to, "d-m-Y");

        return Excel::download(new StockHistoryExport($sortHistoryDate), $formatFileName . '.xlsx');
    }
}
