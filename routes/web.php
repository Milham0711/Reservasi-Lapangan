<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\User\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', function () {
    return redirect()->route('login');
});

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Lapangan Management
    Route::get('/lapangan', [AdminController::class, 'lapanganIndex'])->name('lapangan.index');
    Route::get('/lapangan/create', [AdminController::class, 'lapanganCreate'])->name('lapangan.create');
    Route::post('/lapangan', [AdminController::class, 'lapanganStore'])->name('lapangan.store');
    Route::get('/lapangan/{id}/edit', [AdminController::class, 'lapanganEdit'])->name('lapangan.edit');
    Route::put('/lapangan/{id}', [AdminController::class, 'lapanganUpdate'])->name('lapangan.update');
    Route::delete('/lapangan/{id}', [AdminController::class, 'lapanganDelete'])->name('lapangan.destroy');
    
    // Reservasi Management
    Route::get('/reservasi', [AdminController::class, 'reservasiIndex'])->name('reservasi.index');
    Route::put('/reservasi/{id}', [AdminController::class, 'reservasiUpdate'])->name('reservasi.update');

    // Reporting Management
    Route::get('/report', [AdminController::class, 'report'])->name('report.index');
    Route::get('/report/data', [AdminController::class, 'reportData'])->name('report.data');
    Route::post('/report/export/excel', [AdminController::class, 'exportExcel'])->name('report.export.excel');
    Route::post('/report/export/pdf', [AdminController::class, 'exportPdf'])->name('report.export.pdf');
});

// User Routes
Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    
    // Lapangan
    Route::get('/lapangan', [UserController::class, 'lapanganIndex'])->name('lapangan.index');
    Route::get('/lapangan/{id}', [UserController::class, 'lapanganShow'])->name('lapangan.show');
    
    // Reservasi
    Route::get('/reservasi', [UserController::class, 'reservasiIndex'])->name('reservasi.index');
    Route::get('/reservasi/create/{lapanganId}', [UserController::class, 'reservasiCreate'])->name('reservasi.create');
    Route::post('/reservasi', [UserController::class, 'reservasiStore'])->name('reservasi.store');
    Route::post('/midtrans/webhook', [UserController::class, 'handleMidtransWebhook'])->name('midtrans.webhook');
    Route::post('/reservasi/{id}/confirm-payment', [UserController::class, 'confirmPayment'])->name('user.reservasi.confirm-payment');
    Route::get('/reservasi/{id}/pay', [UserController::class, 'showPaymentPage'])->name('reservasi.pay');
});

// Redirect to appropriate dashboard
Route::get('/dashboard', function () {
    if (auth()->user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('user.dashboard');
})->middleware('auth')->name('dashboard');