<?php

namespace App\Imports;

use App\Models\License;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;

class LicensesImport implements ToModel, WithHeadingRow, WithValidation, WithChunkReading, WithBatchInserts, SkipsOnFailure, SkipsEmptyRows, WithEvents, WithMultipleSheets
{
    use SkipsFailures, RegistersEventListeners;

    private $successCount = 0;
    private $sheetName = '';

    /**
     * By returning an empty array, all sheets will be imported by default, 
     * using the main import class and triggering the sheet events.
     */
    public function sheets(): array
    {
        return [
            $this
        ];
    }

    /**
     * @return int
     */
    public function headingRow(): int
    {
        return 4;
    }

    /**
     * Register a listener for the BeforeSheet event to capture the sheet name.
     */
    public static function beforeSheet(BeforeSheet $event)
    {
        $importer = $event->getConcernable();
        if ($importer instanceof self) {
            $importer->sheetName = $event->getSheet()->getTitle();
        }
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $this->successCount++;

        return new License([
            'vendo_box_no'     => $row['vendo_box_no'] ?? $row['vendo_box_no'] ?? null,
            'vendo_machine'    => $row['vendo_machine'] ?? null,
            'license'          => $row['license'] ?? null,
            'device_id'        => $row['device_id'] ?? null,
            'description'      => $row['description'] ?? null,
            'date'             => isset($row['date']) ? Carbon::parse($row['date'])->toDateString() : null,
            'technician'       => $row['technician'] ?? null,
            'email'            => $row['pisofi_email_lpb_radius_id'] ?? null,
            'customer_name'    => $row['customer_name'] ?? null,
            'address'          => $row['address'] ?? null,
            'contact'          => $row['contact'] ?? null,
            'sheet_name'       => $this->sheetName,
        ]);
    }

    public function rules(): array
    {
        return [
            '*.pisofi_email_lpb_radius_id' => 'nullable|string',
            '*.vendo_box_no' => 'nullable|string',
            '*.vendo_machine' => 'nullable|string',
            '*.license' => 'nullable|string',
            '*.device_id' => 'nullable|string',
            '*.description' => 'nullable|string',
            '*.date' => 'nullable|date',
            '*.technician' => 'nullable|string',
            '*.customer_name' => 'nullable|string',
            '*.address' => 'nullable|string',
            '*.contact' => 'nullable|string',
        ];
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function getSuccessCount(): int
    {
        return $this->successCount;
    }

    public function onFailure(Failure ...$failures)
    {
        foreach ($failures as $failure) {
            Log::error('Import failure on row ' . $failure->row() . ' in sheet ' . $this->sheetName . ': ' . implode(', ', $failure->errors()));
        }

        $this->failures = array_merge($this->failures ?? [], $failures);
    }
}
