<?php

namespace App\Exports;

use App\Models\Pallet;
use Maatwebsite\Excel\Concerns\FromCollection;

class PalletExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Pallet::all();
    }
}
