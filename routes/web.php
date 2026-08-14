<?php

use App\Http\Controllers\Admin\DriverController as AdminDriverController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ParcelController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TrackController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('welcome'))->name('home');

Route::get('/send',              [ParcelController::class, 'create'])->name('send');
Route::get('/track/{orderNumber?}', [TrackController::class, 'show'])->name('track');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('admin')
    ->middleware(['auth', 'verified', 'admin'])
    ->name('admin.')
    ->group(function () {
        Route::get('/drivers',                      [AdminDriverController::class, 'index'])->name('drivers.index');
        Route::get('/drivers/{driver}',             [AdminDriverController::class, 'show'])->name('drivers.show');
        Route::patch('/drivers/{driver}/trust',     [AdminDriverController::class, 'updateTrust'])->name('drivers.trust');
        Route::patch('/drivers/{driver}/active',    [AdminDriverController::class, 'toggleActive'])->name('drivers.active');

        Route::get('/orders',                       [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}',               [AdminOrderController::class, 'show'])->name('orders.show');
        Route::patch('/orders/{order}/status',      [AdminOrderController::class, 'updateStatus'])->name('orders.status');
        Route::patch('/orders/{order}/assign',      [AdminOrderController::class, 'assignDriver'])->name('orders.assign');
    });

require __DIR__.'/auth.php';
