<?php

namespace App\Exports;
// namespace App;

use App\Models\StockHistory;
use App\Models\User;
use Carbon\Carbon;
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


class UserExport implements FromQuery, ShouldAutoSize, WithHeadings, WithMapping
{
    use Exportable;

    public function __construct(string $role, string $startDate, string $endDate)
    {
        $this->level = $role;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }


    public function map($item): array
    {
        return [
            $item->id,
            $item->name,
            $item->email,
            $item->level,
            $item->joined_at,
            // date_format($item->joined_at, "D/d/m/y H:i:s"),
            $item->updated_at
            // date_format($item->updated_at, "D/d/m/y H:i:s"),
        ];
    }

    public function query()
    {
        $date_from = Carbon::parse($this->startDate)->startOfDay();
        $date_to = Carbon::parse($this->endDate)->endOfDay();

        if ($this->level == "all") {;
            return User::query()->whereBetween('joined_at', [$date_from, $date_to]);
        } else {
            return User::query()->where('level', $this->level)->whereBetween('joined_at', [$date_from, $date_to]);
        }
    }

    public function headings(): array
    {
        return ["ID", "username", "Email", "Role", "Joined At", "Updated At"];
    }
}
