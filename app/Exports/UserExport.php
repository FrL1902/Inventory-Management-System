<?php

namespace App\Exports;
// namespace App;

use App\Models\StockHistory;
use App\Models\User;
use Illuminate\Contracts\Support\Responsable;
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
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;


class UserExport implements FromQuery, ShouldAutoSize, WithHeadings
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

    public function headings(): array
    {
        return ["ID", "username", "Email", "Joined At", "Role", "Created At", "Updated At"];
    }
}
