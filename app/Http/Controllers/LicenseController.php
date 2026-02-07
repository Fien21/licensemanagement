<?php

namespace App\Http\Controllers;

use App\Models\License;
use App\Models\HistoryLog;
use Illuminate\Http\Request;
use App\Imports\LicensesImport;
use App\Exports\LicensesExport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LicenseController extends Controller
{
    public function index(Request $request)
    {
        $view = $request->input('view', 'active');
        $query = $view === 'archived' ? License::onlyTrashed() : License::query();

        // Filter by Sheet Name (Tabs)
        if ($request->filled('sheet_name')) {
            $query->where('sheet_name', $request->input('sheet_name'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('vendo_box_no', 'like', "%{$search}%")
                    ->orWhere('license', 'like', "%{$search}%")
                    ->orWhere('device_id', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('date', 'like', "%{$search}%")
                    ->orWhere('technician', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('lpb_radius_id', 'like', "%{$search}%")
                    ->orWhere('customer_name', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%")
                    ->orWhere('contact', 'like', "%{$search}%")
                    ->orWhere('sheet_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('sort_by')) {
            $sortBy = $request->input('sort_by');
            if ($sortBy === 'newest') {
                $query->orderBy('created_at', 'desc');
            } elseif ($sortBy === 'oldest') {
                $query->orderBy('created_at', 'asc');
            } elseif ($sortBy === 'name_asc') {
                $query->orderBy('customer_name', 'asc');
            } elseif ($sortBy === 'name_desc') {
                $query->orderBy('customer_name', 'desc');
            } elseif ($sortBy === 'modified_newest') {
                $query->orderBy('updated_at', 'desc');
            } elseif ($sortBy === 'modified_oldest') {
                $query->orderBy('updated_at', 'asc');
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }
        
        $totalLicenses = License::count();
        $totalArchived = License::onlyTrashed()->count();

        // Get counts for each category tab
        $sheetCounts = License::select('sheet_name', DB::raw('count(*) as total'))
            ->groupBy('sheet_name')
            ->pluck('total', 'sheet_name')
            ->all();

        $licenses = $query->paginate(50)->appends($request->all());

        if ($view === 'archived') {
            return view('licenses.archived', compact('licenses', 'totalLicenses', 'sheetCounts', 'view', 'totalArchived'));
        }

        return view('licenses.index', compact('licenses', 'totalLicenses', 'sheetCounts', 'view', 'totalArchived'));
    }

    public function show(License $license)
    {
        $historyLogs = HistoryLog::where('email', $license->email)->get();
        return view('licenses.show', compact('license', 'historyLogs'));
    }

    public function edit(License $license)
    {
        $sheetNames = License::select('sheet_name')->distinct()->pluck('sheet_name');
        return view('licenses.edit', compact('license', 'sheetNames'));
    }

    public function update(Request $request, License $license)
    {
        $request->validate([
            'sheet_name' => 'required',
            'vendo_box_no' => 'nullable',
            'license' => 'nullable',
            'device_id' => 'nullable',
            'description' => 'nullable',
            'date' => 'nullable|date',
            'technician' => 'nullable',
            'email' => 'required',
            'lpb_radius_id' => 'nullable',
            'customer_name' => 'nullable',
            'address' => 'nullable',
            'contact' => 'nullable',
        ]);

        $license->update($request->all());

        return redirect('/licenses')->with('success', 'License updated successfully.');
    }

    public function create()
    {
        $sheetNames = License::select('sheet_name')->distinct()->pluck('sheet_name');
        return view('licenses.create', compact('sheetNames'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'sheet_name' => 'required',
            'vendo_box_no' => 'nullable',
            'license' => 'nullable',
            'device_id' => 'nullable',
            'description' => 'nullable',
            'date' => 'nullable|date',
            'technician' => 'nullable',
            'email' => 'required',
            'lpb_radius_id' => 'nullable',
            'customer_name' => 'nullable',
            'address' => 'nullable',
            'contact' => 'nullable',
        ]);

        License::create($request->all());

        return redirect('/licenses')->with('success', 'License created successfully.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xlsx'
        ]);

        $import = new LicensesImport;
        
        try {
            Excel::import($import, $request->file('file'));
        } catch (ValidationException $e) {
            // Exceptions handled by import class
        }

        $successCount = $import->getSuccessCount();
        $failures = $import->failures();

        if ($failures->count() > 0) {
            $errorMessage = $successCount . ' licenses imported successfully. ';
            $errorMessage .= $failures->count() . ' licenses failed to import. ';
            $error_rows = [];
            foreach ($failures->take(5) as $failure) {
                $error_rows[] = 'Row ' . $failure->row() . ': ' . implode(', ', $failure->errors());
            }
            $errorMessage .= 'Here are the first few errors: ' . implode('; ', $error_rows);
            if ($failures->count() > 5) {
                $errorMessage .= ' (see log for all errors)';
            }
            return redirect('/licenses')->with('error', $errorMessage);
        }

        return redirect('/licenses')->with('success', $successCount . ' licenses imported successfully.');
    }

    public function export(Request $request)
    {
        // Path to your custom formatted template
        $templatePath = public_path('sample_exports/license_sample_exports.xlsx');
        
        // Load the template
        $spreadsheet = IOFactory::load($templatePath);
        
        // Get the data to export and group by sheet_name
        $licensesBySheet = (new LicensesExport($request))->collection()->groupBy('sheet_name');
        
        // Iterate over each sheet in the spreadsheet
        foreach ($spreadsheet->getSheetNames() as $sheetName) {
            // Check if there is data for this sheet
            if (isset($licensesBySheet[$sheetName])) {
                $sheet = $spreadsheet->getSheetByName($sheetName);
                $licenses = $licensesBySheet[$sheetName];
                
                // Start writing data from row 4
                $row = 4;
                foreach ($licenses as $license) {
                    $sheet->setCellValue('A' . $row, $license->vendo_box_no);
                    $sheet->setCellValue('B' . $row, $license->license);
                    $sheet->setCellValue('C' . $row, $license->device_id);
                    $sheet->setCellValue('D' . $row, $license->description);
                    $sheet->setCellValue('E' . $row, $license->date);
                    $sheet->setCellValue('F' . $row, $license->technician);
                    $sheet->setCellValue('G' . $row, $license->email);
                    $sheet->setCellValue('H' . $row, $license->lpb_radius_id);
                    $sheet->setCellValue('I' . $row, $license->customer_name);
                    $sheet->setCellValue('J' . $row, $license->address);
                    $sheet->setCellValue('K' . $row, $license->contact);
                    $row++;
                }
            }
        }
        
        $fileName = 'licenses_export_' . date('Y-m-d') . '.xlsx';
        $writer = new Xlsx($spreadsheet);
        
        // Create a temporary file to save the spreadsheet
        $temp_file = tempnam(sys_get_temp_dir(), 'export');
        $writer->save($temp_file);
        
        return response()->download($temp_file, $fileName)->deleteFileAfterSend(true);
    }

    public function archive(License $license)
    {
        $license->delete();
        return redirect('/licenses')->with('success', 'License archived successfully.');
    }

    public function archived(Request $request)
    {
        return redirect()->route('licenses.index', ['view' => 'archived']);
    }

    public function restore($id)
    {
        License::onlyTrashed()->find($id)->restore();
        return redirect()->route('licenses.index', ['view' => 'archived'])->with('success', 'License restored successfully.');
    }

    public function delete($id)
    {
        License::onlyTrashed()->find($id)->forceDelete();
        return redirect()->route('licenses.index', ['view' => 'archived'])->with('success', 'License deleted permanently.');
    }

    public function bulkArchive(Request $request)
    {
        $ids = $request->input('ids');
        if($ids) {
            License::whereIn('id', $ids)->delete();
        }
        return redirect('/licenses')->with('success', 'Selected licenses have been archived.');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');
        if($ids) {
            License::whereIn('id', $ids)->forceDelete();
        }
        return redirect('/licenses')->with('success', 'Selected licenses have been permanently deleted.');
    }

    public function bulkRestore(Request $request)
    {
        $ids = $request->input('ids');
        if($ids) {
            License::onlyTrashed()->whereIn('id', $ids)->restore();
        }
        return redirect()->route('licenses.index', ['view' => 'archived'])->with('success', 'Selected licenses have been restored.');
    }

    public function bulkDeletePermanently(Request $request)
    {
        $ids = $request->input('ids');
        if($ids) {
            License::onlyTrashed()->whereIn('id', $ids)->forceDelete();
        }
        return redirect()->route('licenses.index', ['view' => 'archived'])->with('success', 'Selected licenses have been permanently deleted.');
    }
}