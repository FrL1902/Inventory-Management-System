<?php

namespace App\Exports;

use App\Models\StockHistory;
use Maatwebsite\Excel\Concerns\FromCollection;

class historyExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return StockHistory::all();
    }
}
