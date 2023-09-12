<?php

namespace App\Exports;

use App\Models\Brand;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class brandExport implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */

    public function __construct($data)
    {
        $this->brandData = $data;
    }

    use Exportable;


    public function collection()
    {
        return $this->brandData;
    }

    public function map($item): array
    {
        return [
            $item->id,
            $item->customer_id,
            $item->customer->customer_name,
            $item->brand_id,
            $item->brand_name,
            $item->created_at,
            // date_format($item->joined_at, "D/d/m/y H:i:s"),
            $item->updated_at,
            // date_format($item->updated_at, "D/d/m/y H:i:s"), //mungkin coba ini tp ntar ae https://stackoverflow.com/questions/15567854/warning-date-format-expects-parameter-1-to-be-datetime
        ];
    }

    public function headings(): array
    {
        return ["ID", "ID Customer", "Nama Customer", "ID Brand", "Nama Brand", "Created At", "Last Updated At"];
    }
}
