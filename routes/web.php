<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\LocationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', [AuthController::class, 'userDashboard'])->name('user.dashboard');
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/admin/reservations', [AdminController::class, 'reservations'])->name('admin.reservations');
Route::get('/admin/fields', [AdminController::class, 'fields'])->name('admin.fields');
Route::get('/admin/fields/create', [AdminController::class, 'createField'])->name('admin.fields.create');
Route::post('/admin/fields', [AdminController::class, 'storeField'])->name('admin.fields.store');
Route::get('/admin/fields/{id}/edit', [AdminController::class, 'editField'])->name('admin.fields.edit');
Route::put('/admin/fields/{id}', [AdminController::class, 'updateField'])->name('admin.fields.update');
Route::delete('/admin/fields/{id}', [AdminController::class, 'deleteField'])->name('admin.fields.delete');
Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
Route::get('/admin/payments', [AdminController::class, 'payments'])->name('admin.payments');
Route::get('/admin/reports', [AdminController::class, 'reports'])->name('admin.reports');

Route::post('/admin/reservations/{id}/status', [AdminController::class, 'updateReservationStatus'])->name('admin.reservations.update-status');
Route::post('/admin/payments/{id}/status', [AdminController::class, 'updatePaymentStatus'])->name('admin.payments.update-status');
Route::post('/admin/fields/{id}/status', [AdminController::class, 'updateFieldStatus'])->name('admin.fields.update-status');

Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
Route::get('/reservations/create', [ReservationController::class, 'create'])->name('reservations.create');

Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
Route::get('/reservations/{id}/edit', [ReservationController::class, 'edit'])->name('reservations.edit');
Route::put('/reservations/{id}', [ReservationController::class, 'update'])->name('reservations.update');
Route::delete('/reservations/{id}', [ReservationController::class, 'destroy'])->name('reservations.destroy');

Route::get('/reservations/{id}/payment', [ReservationController::class, 'payment'])->name('reservations.payment');
Route::post('/reservations/{id}/payment', [ReservationController::class, 'processPayment'])->name('reservations.process-payment');

Route::post('/notifications/clear', [NotificationController::class, 'clearNotifications'])->name('notifications.clear');

// Locations index (list/filter by type)
Route::get('/locations', [LocationController::class, 'index'])->name('locations.index');

// Location detail (used by dashboard slider)
Route::get('/locations/{id}', [LocationController::class, 'show'])->name('locations.show');

// API route to get fields by sport type
Route::get('/api/fields/{sportType}', [ReservationController::class, 'getFieldsBySportType'])->name('api.fields.by-type');

// Debug routes removed. They were only intended for local troubleshooting and
// have been cleaned up. If you still need diagnostics, re-add them or run
// the temporary routes locally while developing.