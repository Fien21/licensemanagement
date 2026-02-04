<?php

namespace App\Http\Controllers;

use App\Models\License;
use Illuminate\Http\Request;
use App\Imports\LicensesImport;
use App\Exports\LicensesExport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

class LicenseController extends Controller
{
    public function index(Request $request)
    {
        $query = License::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('vendo_box_no', 'like', "%{$search}%")
                    ->orWhere('vendo_machine', 'like', "%{$search}%")
                    ->orWhere('license', 'like', "%{$search}%")
                    ->orWhere('device_id', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('date', 'like', "%{$search}%")
                    ->orWhere('technician', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('customer_name', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%")
                    ->orWhere('contact', 'like', "%{$search}%");
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
        }
        
        $totalLicenses = License::count();
        $licenses = $query->paginate(10)->appends($request->all());

        return view('welcome', compact('licenses', 'totalLicenses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'vendo_box_no' => 'nullable',
            'vendo_machine' => 'nullable',
            'license' => 'nullable',
            'device_id' => 'nullable',
            'description' => 'nullable',
            'date' => 'nullable|date',
            'technician' => 'nullable',
            'email' => 'required',
            'customer_name' => 'nullable',
            'address' => 'nullable',
            'contact' => 'nullable',
        ]);

        License::create($request->all());

        return redirect('/')->with('success', 'License created successfully.');
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
            // Don't handle validation exceptions here, they are handled by the import class
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
            return redirect('/')->with('error', $errorMessage);
        }

        return redirect('/')->with('success', $successCount . ' licenses imported successfully.');
    }

    public function export()
    {
        return Excel::download(new LicensesExport, 'licenses.xlsx');
    }

    public function archive(License $license)
    {
        $license->delete();
        return redirect('/')->with('success', 'License archived successfully.');
    }

    public function archived()
    {
        $licenses = License::onlyTrashed()->paginate(10);
        return view('archived', compact('licenses'));
    }

    public function restore($id)
    {
        License::onlyTrashed()->find($id)->restore();
        return redirect('/licenses/archived')->with('success', 'License restored successfully.');
    }

    public function delete($id)
    {
        License::onlyTrashed()->find($id)->forceDelete();
        return redirect('/licenses/archived')->with('success', 'License deleted permanently.');
    }

    public function bulkArchive(Request $request)
    {
        $ids = $request->input('ids');
        License::whereIn('id', $ids)->delete();
        return redirect('/')->with('success', 'Selected licenses have been archived.');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');
        License::whereIn('id', $ids)->forceDelete();
        return redirect('/')->with('success', 'Selected licenses have been permanently deleted.');
    }
}
