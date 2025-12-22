<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ToyController as AdminToyController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\StatusController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ImportController;
use App\Http\Controllers\Admin\ReportController;

// Public Routes
Route::get('/', [PublicController::class, 'index'])->name('public.index');
Route::get('/toy/{toy}', [PublicController::class, 'show'])->name('public.show');

// Admin Auth Routes
Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

// Admin Protected Routes
Route::prefix('admin')->middleware('auth')->name('admin.')->group(function () {
    // Dashboard redirect
    Route::get('/', fn() => redirect()->route('admin.toys.index'));

    // Toys management
    Route::get('/toys', [AdminToyController::class, 'index'])->name('toys.index');
    Route::get('/toys/create', [AdminToyController::class, 'create'])->name('toys.create');
    Route::post('/toys', [AdminToyController::class, 'store'])->name('toys.store');
    Route::get('/toys/{toy}/edit', [AdminToyController::class, 'edit'])->name('toys.edit');
    Route::put('/toys/{toy}', [AdminToyController::class, 'update'])->name('toys.update');
    Route::delete('/toys/{toy}', [AdminToyController::class, 'destroy'])->name('toys.destroy');
    Route::patch('/toys/{toy}/status', [AdminToyController::class, 'updateStatus'])->name('toys.updateStatus');

    // Categories
    Route::resource('categories', CategoryController::class)->except(['show']);

    // Statuses
    Route::resource('statuses', StatusController::class)->except(['show']);

    // Locations
    Route::resource('locations', LocationController::class)->except(['show']);

    // Users
    Route::resource('users', UserController::class)->except(['show']);

    // Import
    Route::get('/import', [ImportController::class, 'index'])->name('import.index');
    Route::post('/import', [ImportController::class, 'store'])->name('import.store');

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/inventory', [ReportController::class, 'inventory'])->name('reports.inventory');
});