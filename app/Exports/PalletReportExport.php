<?php

namespace App\Exports;

use App\Models\InPallet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PalletReportExport implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping
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
            date_format(date_create($item->user_date), 'D d-m-Y'),
            $item->description,
            "http://wms.intanutama.co.id/storage/" . $item->item_pictures,
        ];
    }

    public function headings(): array
    {
        return ["Nama Customer", "Nama Brand", "ID Barang", "Nama Barang", "Stok", "BIN", "Tanggal Sampai", "Deskripsi", "Link Gambar Barang"];
    }
}
