<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/send', function () {
    return view('pages.send');
})->name('send');

Route::get('/track/{orderNumber?}', function (?string $orderNumber = null) {
    $task = $orderNumber
        ? \App\Models\Task::where('order_number', strtoupper(trim($orderNumber)))->first()
        : null;
    return view('pages.track', [
        'task'        => $task,
        'orderNumber' => $orderNumber ? strtoupper(trim($orderNumber)) : null,
    ]);
})->name('track');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
