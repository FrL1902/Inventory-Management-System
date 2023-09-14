<?php

namespace App\Exports;

use App\Models\Pallet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;

class CustomerReportExport implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping
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
            $item->customer_name,
            $item->brand_name,
            $item->item_id,
            $item->item_name,
            $item->stock,
            $item->bin,
            // "http://127.0.0.1:8000/storage/" . $item->item_pictures,
            "http://wms.intanutama.co.id/storage/" . $item->item_pictures,
        ];
    }

    public function headings(): array
    {
        return ["Nama Customer", "Nama Brand", "ID Barang", "Nama Barang", "Stok", "Palet", "Link Gambar Barang"];
    }
}
