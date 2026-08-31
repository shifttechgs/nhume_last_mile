<?php

use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Admin\DriverController as AdminDriverController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\RouteController as AdminRouteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JourneysController;
use App\Http\Controllers\ParcelController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TrackController;
use App\Http\Controllers\Transporter\JourneyController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('welcome'))->name('home');

Route::get('/send',                 [ParcelController::class, 'create'])->name('send');
Route::get('/track/{orderNumber?}', [TrackController::class, 'show'])->name('track');
Route::get('/journeys',             [JourneysController::class, 'index'])->name('journeys');

// Public informational pages
Route::get('/about',            fn () => view('pages.about'))->name('about');
Route::get('/contact',          fn () => view('pages.contact'))->name('contact');
Route::get('/safety',           fn () => view('pages.safety'))->name('safety');
Route::get('/report',           fn () => view('pages.report'))->name('report');
Route::get('/blog',             fn () => view('pages.blog'))->name('blog');
Route::get('/become-a-partner', fn () => view('pages.partner'))->name('partner');
Route::get('/careers',          fn () => view('pages.careers'))->name('careers');
Route::get('/terms',            fn () => view('pages.terms'))->name('terms');
Route::get('/privacy',          fn () => view('pages.privacy'))->name('privacy');
Route::get('/cookies',          fn () => view('pages.cookies'))->name('cookies');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('transporter')
    ->middleware(['auth', 'verified', 'transporter'])
    ->name('transporter.')
    ->group(function () {
        Route::get('/journeys',                         [JourneyController::class, 'index'])->name('journeys.index');
        Route::get('/journeys/create',                  [JourneyController::class, 'create'])->name('journeys.create');
        Route::post('/journeys',                        [JourneyController::class, 'store'])->name('journeys.store');
        Route::patch('/journeys/{journey}/cancel',      [JourneyController::class, 'cancel'])->name('journeys.cancel');
    });

Route::prefix('admin')
    ->middleware(['auth', 'verified', 'admin'])
    ->name('admin.')
    ->group(function () {
        // Customers
        Route::get('/customers',                    [AdminCustomerController::class, 'index'])->name('customers.index');
        Route::get('/customers/create',             [AdminCustomerController::class, 'create'])->name('customers.create');
        Route::post('/customers',                   [AdminCustomerController::class, 'store'])->name('customers.store');
        Route::get('/customers/{customer}',         [AdminCustomerController::class, 'show'])->name('customers.show');
        Route::get('/api/customers',                [AdminCustomerController::class, 'search'])->name('customers.search');

        // Drivers
        Route::get('/drivers',                      [AdminDriverController::class, 'index'])->name('drivers.index');
        Route::get('/drivers/create',               [AdminDriverController::class, 'create'])->name('drivers.create');
        Route::post('/drivers',                     [AdminDriverController::class, 'store'])->name('drivers.store');
        Route::get('/drivers/{driver}',             [AdminDriverController::class, 'show'])->name('drivers.show');
        Route::patch('/drivers/{driver}/trust',     [AdminDriverController::class, 'updateTrust'])->name('drivers.trust');
        Route::patch('/drivers/{driver}/active',    [AdminDriverController::class, 'toggleActive'])->name('drivers.active');

        // Routes (delivery corridors)
        Route::get('/routes',                       [AdminRouteController::class, 'index'])->name('routes.index');
        Route::get('/routes/create',                [AdminRouteController::class, 'create'])->name('routes.create');
        Route::post('/routes',                      [AdminRouteController::class, 'store'])->name('routes.store');
        Route::get('/routes/{route}/edit',          [AdminRouteController::class, 'edit'])->name('routes.edit');
        Route::put('/routes/{route}',               [AdminRouteController::class, 'update'])->name('routes.update');
        Route::patch('/routes/{route}/toggle',      [AdminRouteController::class, 'toggleActive'])->name('routes.toggle');
        Route::delete('/routes/{route}',            [AdminRouteController::class, 'destroy'])->name('routes.destroy');

        // Orders
        Route::get('/orders',                       [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/create',                [AdminOrderController::class, 'create'])->name('orders.create');
        Route::post('/orders',                      [AdminOrderController::class, 'store'])->name('orders.store');
        Route::get('/orders/{order}',               [AdminOrderController::class, 'show'])->name('orders.show');
        Route::patch('/orders/{order}/status',      [AdminOrderController::class, 'updateStatus'])->name('orders.status');
        Route::patch('/orders/{order}/assign',      [AdminOrderController::class, 'assignDriver'])->name('orders.assign');
    });

require __DIR__.'/auth.php';
