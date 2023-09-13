<?php

namespace App\Exports;

use App\Models\PalletHistory;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PalletHistoryExport implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($data)
    {
        $this->palletHistoryData = $data;
    }

    use Exportable;

    public function collection()
    {
        return $this->palletHistoryData;
    }

    public function map($item): array
    {
        return [
            $item->item_id,
            $item->item_name,
            $item->stock,
            $item->bin,
            $item->status,
            $item->user,
            $item->created_at,
            // date_format($item->joined_at, "D/d/m/y H:i:s"),
            $item->updated_at,
            // date_format($item->updated_at, "D/d/m/y H:i:s"), //mungkin coba ini tp ntar ae https://stackoverflow.com/questions/15567854/warning-date-format-expects-parameter-1-to-be-datetime
        ];
    }

    public function headings(): array
    {
        return [
            // "ID", "Item ID", "Item Name", "Status", "Value", "By User", "Created At", "Last Updated At"
            "ID Barang", "Nama Barang", "Stok", "BIN", "Status", "Oleh User", "Created At", "Last Updated At"
    ];
    }
}
