<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LicenseController;
use App\Http\Controllers\SchemaController;

Route::get('/', [LicenseController::class, 'index']);

Route::post('/licenses', [LicenseController::class, 'store']);

Route::post('/licenses/import', [LicenseController::class, 'import']);

Route::get('/licenses/export', [LicenseController::class, 'export']);

Route::post('/licenses/{license}/archive', [LicenseController::class, 'archive']);

Route::get('/licenses/archived', [LicenseController::class, 'archived']);

Route::post('/licenses/archived/{id}/restore', [LicenseController::class, 'restore']);

Route::post('/licenses/archived/{id}/delete', [LicenseController::class, 'delete']);

Route::post('/licenses/bulk-archive', [LicenseController::class, 'bulkArchive']);

Route::post('/licenses/bulk-delete', [LicenseController::class, 'bulkDelete']);

Route::get('/schema', [SchemaController::class, 'index']);
