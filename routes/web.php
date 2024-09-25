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

    Route::resource('order/create',OrderController::class)->names([
        'create' => 'order.create',   
        'index' => 'order.index',
        'store' => 'order.store',
        'show' => 'order.show',
        'edit' => 'order.edit',
        'update' => 'order.update',
        'destroy' => 'order.destroy',
    ]);
});
