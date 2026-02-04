<?php

namespace App\Exports;

use App\Models\License;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStartRow;

class LicensesExport implements FromCollection, WithMapping, WithStartRow
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = License::query();

        // Apply filters so the export matches the current view on screen
        if ($this->request->filled('search')) {
            $search = $this->request->search;
            $query->where(function($q) use ($search) {
                $q->where('customer_name', 'like', "%$search%")
                  ->orWhere('license', 'like', "%$search%")
                  ->orWhere('vendo_machine', 'like', "%$search%")
                  ->orWhere('vendo_box_no', 'like', "%$search%")
                  ->orWhere('device_id', 'like', "%$search%");
            });
        }

        if ($this->request->filled('sheet_name')) {
            $query->where('sheet_name', $this->request->sheet_name);
        }

        return $query->get();
    }

    /**
     * StartRow 4: This leaves Rows 1, 2, and 3 of your template 
     * (license_sample_exports.xlsx) untouched.
     */
    public function startRow(): int
    {
        return 4;
    }

    /**
     * Mapping data to Columns A through L (12 columns)
     * This removes M through Q automatically.
     */
    public function map($license): array
    {
        return [
            $license->sheet_name,    // Column A
            $license->vendo_box_no,  // Column B
            $license->vendo_machine, // Column C
            $license->license,       // Column D
            $license->device_id,     // Column E
            $license->description,   // Column F
            $license->date,          // Column G
            $license->technician,    // Column H
            $license->email,         // Column I
            $license->customer_name, // Column J
            $license->address,       // Column K
            $license->contact,       // Column L
        ];
    }
}