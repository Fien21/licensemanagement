<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LicenseController;
use App\Http\Controllers\SchemaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Active License Routes
Route::get('/licenses', [LicenseController::class, 'index'])->name('licenses.index');
Route::post('/licenses', [LicenseController::class, 'store']);
Route::post('/licenses/import', [LicenseController::class, 'import']);
Route::get('/licenses/export', [LicenseController::class, 'export']);
Route::post('/licenses/bulk-archive', [LicenseController::class, 'bulkArchive']);
Route::post('/licenses/bulk-delete', [LicenseController::class, 'bulkDelete']);

// Archived License Routes (Views and Single Actions)
Route::get('/licenses/archived', [LicenseController::class, 'archived'])->name('archived');
Route::post('/licenses/archived/{id}/restore', [LicenseController::class, 'restore']);
Route::post('/licenses/archived/{id}/delete', [LicenseController::class, 'delete']);

// NEW: Archived License Bulk Actions
Route::post('/licenses/archived/bulk-restore', [LicenseController::class, 'bulkRestore']);
Route::post('/licenses/archived/bulk-delete', [LicenseController::class, 'bulkDeletePermanently']);

// License Details and Update (with trashed support)
Route::get('/licenses/{license}', [LicenseController::class, 'show'])->name('licenses.show')->withTrashed();
Route::get('/licenses/{license}/edit', [LicenseController::class, 'edit'])->name('licenses.edit')->withTrashed();
Route::put('/licenses/{license}', [LicenseController::class, 'update'])->name('licenses.update')->withTrashed();
Route::post('/licenses/{license}/archive', [LicenseController::class, 'archive'])->withTrashed();

// Schema Routes
Route::get('/schema', [SchemaController::class, 'index']);

// User Management Routes
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
Route::post('/users/{id}/archive', [UserController::class, 'archive'])->name('users.archive');
Route::get('/users/archived', [UserController::class, 'archived'])->name('users.archived');
Route::post('/users/archived/{id}/restore', [UserController::class, 'restore'])->name('users.restore');
Route::post('/users/archived/{id}/delete', [UserController::class, 'delete'])->name('users.delete');
Route::post('/users/bulk-archive', [UserController::class, 'bulkArchive'])->name('users.bulkArchive');
Route::post('/users/bulk-delete', [UserController::class, 'bulkDelete'])->name('users.bulkDelete');
Route::post('/users/bulk-restore', [UserController::class, 'bulkRestore'])->name('users.bulkRestore');
Route::post('/users/search', [UserController::class, 'search'])->name('users.search');