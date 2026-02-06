<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LicenseController;
use App\Http\Controllers\SchemaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/licenses', [LicenseController::class, 'index'])->name('licenses.index');
Route::post('/licenses', [LicenseController::class, 'store']);
Route::get('/licenses/archived', [LicenseController::class, 'archived'])->name('archived');
Route::post('/licenses/import', [LicenseController::class, 'import']);
Route::get('/licenses/export', [LicenseController::class, 'export']);
Route::post('/licenses/bulk-archive', [LicenseController::class, 'bulkArchive']);
Route::post('/licenses/bulk-delete', [LicenseController::class, 'bulkDelete']);

Route::get('/licenses/{license}', [LicenseController::class, 'show'])->name('licenses.show')->withTrashed();
Route::get('/licenses/{license}/edit', [LicenseController::class, 'edit'])->name('licenses.edit')->withTrashed();
Route::put('/licenses/{license}', [LicenseController::class, 'update'])->name('licenses.update')->withTrashed();
Route::post('/licenses/{license}/archive', [LicenseController::class, 'archive'])->withTrashed();

Route::post('/licenses/archived/{id}/restore', [LicenseController::class, 'restore']);
Route::post('/licenses/archived/{id}/delete', [LicenseController::class, 'delete']);

Route::get('/schema', [SchemaController::class, 'index']);

Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/archived', [UserController::class, 'archived'])->name('users.archived');
Route::post('/users/archived/{id}/restore', [UserController::class, 'restore']);
Route::post('/users/archived/{id}/delete', [UserController::class, 'delete']);
