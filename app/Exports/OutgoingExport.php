<?php

namespace App\Exports;

use App\Models\Outgoing;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class OutgoingExport implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */

    public function __construct($data)
    {
        $this->outgoingData = $data;
    }

    use Exportable;

    public function headings(): array
    {
        return [
            'ID', 'Customer Name', 'Brand Name', 'Item Name', 'Date Departed', 'Stock Before', 'Stock Taken', 'Stock After', 'description', 'picture link'
        ];
    }

    public function collection()
    {
        return $this->outgoingData;
    }

    public function map($item): array
    {
        return [
            $item->id,
            // $item->customer->customer_name,
            // $item->brand->brand_name,
            // $item->item->item_name,
            (is_null($item->customer_name)) ? $item->customer->customer_name : $item->customer_name,
            (is_null($item->brand_name)) ? $item->brand->brand_name : $item->brand_name,
            (is_null($item->item_name)) ? $item->item->item_name : $item->item_name,
            // $item->depart_date,
            date_format(date_create($item->depart_date), 'd-m-Y'),
            $item->stock_before,
            $item->stock_taken,
            ($item->stock_now == 0) ? "0" : $item->stock_now,
            $item->description,
            // $item->picture_link,
            "http://127.0.0.1:8000/storage/" . $item->item_pictures,
            // date_format($item->created_at, "D/d/m/y H:i:s"),
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {
                $event->sheet->getStyle('A1:J1')->applyFromArray([
                    'font' => ['bold' => true]
                ]);
                $styleArrayHeading = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                ];
                $styleArrayContent = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                ];

                $frontTolastData = 'A2:J' . strval(count($this->outgoingData) + 1);
                $event->sheet->getStyle('A1:J1')->applyFromArray($styleArrayHeading);
                $event->sheet->getStyle($frontTolastData)->applyFromArray($styleArrayContent);
                $event->sheet->getStyle('A1:J1')->getAlignment()->setHorizontal('center');
                $event->sheet->getStyle($frontTolastData)->getAlignment()->setHorizontal('left');
            },

        ];
    }
}
