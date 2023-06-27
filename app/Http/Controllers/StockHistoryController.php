<?php

namespace App\Http\Controllers;

use App\Exports\stockHistoryExport;
use App\Models\StockHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class StockHistoryController extends Controller
{
    public function filterHistoryDate(Request $request)
    {

        $date_from = Carbon::parse($request->startRange)->startOfDay();
        $date_to = Carbon::parse($request->endRange)->endOfDay();

        $history = StockHistory::all()->whereBetween('created_at', [$date_from, $date_to]);

        $request->session()->flash('deleteFilterButton', 'yea');

        return view('itemHistory', compact('history'));
    }

    public function exportItemHistory(Request $request)
    {
        // dd($request->itemHistoryExport);

        $sortHistory = StockHistory::all()->where('item_name', $request->itemHistoryExport);

        return Excel::download(new stockHistoryExport($sortHistory), 'History milik item ' . $request->itemHistoryExport . '.xlsx');
    }

    public function exportHistoryByDate(Request  $request)
    {
        $date_from = Carbon::parse($request->startRange)->startOfDay();
        $date_to = Carbon::parse($request->endRange)->endOfDay();

        $sortHistoryDate = StockHistory::all()->whereBetween('created_at', [$date_from, $date_to]);
        $formatFileName = 'DataHistoryItem ' . date_format($date_from, "d-m-Y") . ' hingga ' . date_format($date_to, "d-m-Y");

        return Excel::download(new StockHistoryExport($sortHistoryDate), $formatFileName . '.xlsx');
    }

    // public function exportIncoming(Request $request)
    // {
    //     $date_from = Carbon::parse($request->startRange)->startOfDay();
    //     $date_to = Carbon::parse($request->endRange)->endOfDay();


    //     // return Excel::download(new IncomingExport($sortCustomer), 'dataBarangDatang.xlsx');
    //     $sortAll = Incoming::all()->whereBetween('created_at', [$date_from, $date_to]);
    //     $formatFileName = 'DataBarangDatang ALL ' . date_format($date_from, "d-m-Y") . ' hingga ' . date_format($date_to, "d-m-Y");

    //     return Excel::download(new IncomingExport($sortAll), $formatFileName . '.xlsx');
    //     // return (new IncomingExport($sortCustomer))->download('Productos.xlsx');
    // }


    // $customer = Customer::find($request->customerBrandExport);

    // $sortBrand = Brand::all()->where('customer_id', $request->customerBrandExport);

    // return Excel::download(new brandExport($sortBrand), 'Brand milik ' .  $customer->customer_name .'.xlsx');
}
