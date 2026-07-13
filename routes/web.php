<?php

use App\Http\Controllers\FarmController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Cow routes (authenticated only; authorization via CowPolicy)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('cows', \App\Http\Controllers\CowController::class)->except(['show']);
});

// Health Record routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('health-records', \App\Http\Controllers\HealthRecordController::class)
        ->except(['show'])
        ->parameter('health-records', 'healthRecord');
});

// Milk Record routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('milk-records', \App\Http\Controllers\MilkRecordController::class)
        ->except(['show'])
        ->parameter('milk-records', 'milkRecord');
});

// Staff routes (admin_farm only)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('staff', \App\Http\Controllers\StaffController::class)->except(['show', 'destroy']);
    Route::patch('staff/{staff}/toggle-status', [\App\Http\Controllers\StaffController::class, 'toggleStatus'])->name('staff.toggle-status');
});

// Farm routes (authenticated only; authorization via FarmPolicy)
Route::middleware(['auth', 'verified'])->group(function () {
    // My Farm — direct access for admin_farm to see their own farm
    Route::get('/my-farm', [FarmController::class, 'myFarm'])->name('my-farm');

    // Farm resource (no separate show page — index + edit cover it)
    Route::resource('farms', FarmController::class)->except(['show']);
});

// Breed routes (authenticated only; authorization via BreedPolicy)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('breeds', \App\Http\Controllers\BreedController::class)->except(['show']);
});

// Feed routes (authenticated only; authorization via FeedPolicy)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('feeds', \App\Http\Controllers\FeedController::class)->except(['show']);
});

// Feed Stock Log routes (authenticated only)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('feed-stock-logs', \App\Http\Controllers\FeedStockLogController::class)
        ->only(['create', 'store'])
        ->parameter('feed-stock-logs', 'feedStockLog');
});

// Feed Record routes (authenticated only; authorization via FeedRecordPolicy)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('feed-records', \App\Http\Controllers\FeedRecordController::class)
        ->except(['show'])
        ->parameter('feed-records', 'feedRecord');
});

// Transaction routes (authenticated only; authorization via TransactionPolicy)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('transactions', \App\Http\Controllers\TransactionController::class)->except(['show']);
});

// Report routes (financial & production — accessible by admin_farm & super_admin)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/reports/financial', [ReportController::class, 'financial'])
        ->middleware('can:viewAny,App\Models\Report')
        ->name('reports.financial');
    Route::get('/reports/production', [ReportController::class, 'production'])
        ->middleware('can:viewAny,App\Models\Report')
        ->name('reports.production');

    // PDF export routes
    Route::get('/reports/financial/pdf', [ReportController::class, 'financialPdf'])
        ->middleware('can:viewAny,App\Models\Report')
        ->name('reports.financial.pdf');
    Route::get('/reports/production/pdf', [ReportController::class, 'productionPdf'])
        ->middleware('can:viewAny,App\Models\Report')
        ->name('reports.production.pdf');
});

// Super Admin routes
Route::middleware(['auth', 'verified', 'role:' . User::ROLE_SUPER_ADMIN])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])
            ->name('dashboard');
    });

// User profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
