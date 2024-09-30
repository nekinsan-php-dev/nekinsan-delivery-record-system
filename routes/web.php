<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\RecordController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('orders', OrderController::class);

    Route::post('/orders/export', [OrderController::class, 'export'])->name('order.export');
    Route::post('/orders/assign-bar-code',[OrderController::class,"assignBarcode"])->name('order.assign.barcode');
    Route::get('orders/invoice/{id}',[OrderController::class,"invoice"])->name('orders.invoice');
    Route::post('orders/invoice-multiple', [OrderController::class, "invoiceMultiple"])->name('orders.invoice-multiple');

    Route::patch('/orders/{order}/mark-delivered', [OrderController::class, 'markDelivered'])->name('orders.markDelivered');
});
