<?php

namespace App\Exports;

use App\Models\StockHistory;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromQuery;
// use Maatwebsite\Excel\Concerns\FromCollection;

// class UserExport implements FromCollection
// {
//     /**
//     * @return \Illuminate\Support\Collection
//     */
//     public function collection()
//     {
//         return StockHistory::all();
//     }
// }

use Maatwebsite\Excel\Concerns\Exportable;

class UserExport implements FromQuery
{
    use Exportable;

    public function __construct(string $year)
    {
        $this->year = $year;
    }

    // INI PAKE YEAR CUMA RANDOM VARIABEL DOANG BUAT TESTING, PLS DONT USE LIKE THIS

    public function query()
    {
        // return User::query();
        // return User::query()->where('level', 'admin');
        if ($this->year == "all") {
            return User::query(); //kalo dikosongin bakal milih semua
        } else {
            return User::query()->where('level', $this->year);
        }
    }

    // return (new InvoicesExport(2018))->download('invoices.xlsx');
}
