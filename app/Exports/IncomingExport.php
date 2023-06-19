<?php

namespace App\Exports;

use App\Models\Incoming;
use Maatwebsite\Excel\Concerns\FromCollection;

class IncomingExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Incoming::all();
    }
}
