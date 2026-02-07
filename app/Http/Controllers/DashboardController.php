<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\License;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $activeLicenses = License::count();
        $archivedLicenses = License::onlyTrashed()->count();
        $totalLicenses = $activeLicenses + $archivedLicenses;

        $licenseStatusData = [
            'active' => $activeLicenses,
            'archived' => $archivedLicenses,
        ];

        return view('dashboard', compact('totalUsers', 'totalLicenses', 'licenseStatusData'));
    }

   
}
