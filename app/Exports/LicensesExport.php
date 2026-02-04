<?php

namespace App\Exports;

use App\Models\License;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LicensesExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return License::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Vendo Box No',
            'Vendo Machine',
            'License',
            'Device ID',
            'Description',
            'Date',
            'Technician',
            'PISOFI Email LPB Radius ID',
            'Customer Name',
            'Address',
            'Contact',
            'Status',
            'Email Verified',
            'Created At',
            'Updated At',
            'Deleted At',
        ];
    }
}
