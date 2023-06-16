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



    public function __construct(string $role, string $startDate, string $endDate)
    {
        $this->level = $role;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    // INI PAKE YEAR CUMA RANDOM VARIABEL DOANG BUAT TESTING, PLS DONT USE LIKE THIS

    public function query()
    {
        // return User::query();
        // return User::query()->where('level', 'admin');
        // dd($this->startDate, $this->endDate);


        $from = date($this->startDate);
        $to = date($this->endDate);
        // dd(132);


        if ($this->level == "all") {
            // return User::query(); //kalo dikosongin bakal milih semua
            // return User::query()->whereBetween('joined_at', [$from, $to]);
            return User::query()->whereBetween('joined_at', [$this->startDate, $this->endDate]);
        } else {
            // $tes = User::query()->where('level', $this->year)->whereBetween('joined_at', [$this->startDate, $this->endDate]);
            // dd($tes);
            // return User::query()->where('level', $this->level)->whereBetween('joined_at', [$from, $to]);
            return User::query()->where('level', $this->level)->whereBetween('joined_at', [$this->startDate, $this->endDate]);
        }

        // $bookingDate = DateTime::createFromFormat('Y-m-d', $request->bookingDate);
        // $bookingDate->setTime(0, 0, 0);
        // $from = clone $bookingDate;
        // $bookingDate->setTime(23, 59, 59);
        // $to = clone $bookingDate;

        // $booking = Booking::where('area_id', '=',  $request->areaId)
        //         ->where('cancelled', '=',  '0')
        //         ->whereBetween('start_date', [$from, $to])
        //         ->get();
    }

    public function headings(): array
    {
        return ["ID", "username", "Email", "Joined At", "Role", "Created At", "Updated At"];
    }
}
