<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class customerExport implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */

    public function __construct($data)
    {
        $this->customerData = $data;
        // $this->valueSortedBy = $value;
    }

    use Exportable;


    public function collection()
    {
        return $this->customerData;
    }

    public function map($item): array
    {
        return [
            // $item->id,
            $item->customer_id,
            $item->customer_name,
            $item->address,
            $item->email,
            $item->phone1,
            $item->phone2,
            $item->fax,
            $item->website,
            $item->pic,
            $item->pic_phone,
            $item->npwp_perusahaan,
            $item->created_at,
            // date_format($item->joined_at, "D/d/m/y H:i:s"),
            $item->updated_at,
            // date_format($item->updated_at, "D/d/m/y H:i:s"), //mungkin coba ini tp ntar ae https://stackoverflow.com/questions/15567854/warning-date-format-expects-parameter-1-to-be-datetime
        ];
    }

    public function headings(): array
    {
        // return ["ID", "ID Customer", "Nama Customer", "Alamat", "Email", "Phone 1", "Phone 2", "Fax", "Website", "Nama Person In Charge (PIC)", "PIC phone", "NPWP Perusahaan", "Created At", "Last Updated At"];
        return ["ID Customer", "Nama Customer", "Alamat", "Email", "Phone 1", "Phone 2", "Fax", "Website", "Nama Person In Charge (PIC)", "PIC phone", "NPWP Perusahaan", "Created At", "Last Updated At"];
    }
}
