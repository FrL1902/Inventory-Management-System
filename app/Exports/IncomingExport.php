<?php

namespace App\Exports;

use App\Models\Incoming;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Shared\Drawing;

class IncomingExport implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping, WithEvents

{
    /**
     * @return \Illuminate\Support\Collection
     */

    // public function __construct($data)
    // {
    //     $this->incomingData = $data;
    // }

    public function __construct($data)
    {
        $this->incomingData = $data;
    }

    use Exportable;

    public function headings(): array
    {
        return [
            'ID', 'customer name', 'brand name', 'item name', 'stock before', 'stock added', 'stock now', 'description', 'picture link', 'time (WIB)'
        ];
    }

    // use Exportable;

    public function collection()
    {
        // return Incoming::all();
        // dd($this->incomingData);
        return $this->incomingData;
    }

    public function map($item): array
    {
        return [
            $item->id,
            $item->customer->customer_name,
            $item->brand->brand_name,
            $item->item_name,
            $item->stock_before,
            $item->stock_added,
            $item->stock_now,
            $item->description,
            $item->picture_link,
            $item->created_at
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {
                $event->sheet->getStyle('A1:J1')->applyFromArray([
                    'font' => ['bold' => true]
                ]);
            },

        ];
    }
}
