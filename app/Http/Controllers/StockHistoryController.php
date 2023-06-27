<?php

namespace App\Http\Controllers;

use App\Models\StockHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StockHistoryController extends Controller
{
    public function filterHistoryDate(Request $request){

        $date_from = Carbon::parse($request->startRange)->startOfDay();
        $date_to = Carbon::parse($request->endRange)->endOfDay();

        $history = StockHistory::all()->whereBetween('created_at', [$date_from, $date_to]);

        $request->session()->flash('deleteFilterButton', 'yea');

        return view('itemHistory', compact('history'));
    }

    // public function exportIncomingItem(Request $request)
    // {
    //     $item = Item::find($request->itemIncoming);
    //     $date_from = Carbon::parse($request->startRange)->startOfDay();
    //     $date_to = Carbon::parse($request->endRange)->endOfDay();

    //     $sortItem = Incoming::all()->where('item_id', $request->itemIncoming)->whereBetween('created_at', [$date_from, $date_to]);
    //     $formatFileName = 'DataBarangDatang Item ' . $item->item_name . ' ' . date_format($date_from, "d-m-Y") . ' hingga ' . date_format($date_to, "d-m-Y");

    //     return Excel::download(new IncomingExport($sortItem),  $formatFileName . '.xlsx');
    // }
}
