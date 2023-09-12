<?php

namespace App\Exports;

use App\Models\Item;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class editItemExport implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */

    public function __construct($data)
    {
        $this->itemData = $data;
    }

    use Exportable;

    public function collection()
    {
        return $this->itemData;
    }

    public function map($item): array
    {
        return [
            $item->id,
            $item->item_id,
            $item->item_name,
            $item->brand_id,
            $item->brand->brand_name,
            $item->customer_id,
            $item->customer->customer_name,
            $item->stocks,
            "http://127.0.0.1:8000/storage/" . $item->item_pictures,
            $item->created_at,
            // date_format($item->joined_at, "D/d/m/y H:i:s"),
            $item->updated_at,
            // date_format($item->updated_at, "D/d/m/y H:i:s"), //mungkin coba ini tp ntar ae https://stackoverflow.com/questions/15567854/warning-date-format-expects-parameter-1-to-be-datetime
        ];
    }

    public function headings(): array
    {
        return ["ID", "ID Barang", "Nama Barang", "ID Brand", "Nama Brand", "ID Customer", "Nama Customer", "Stok", "link gambar", "Created At", "Last Updated At"];
    }
}
