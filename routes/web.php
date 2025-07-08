<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoiceFormatController;
use App\Http\Controllers\ProfileController;
use App\Models\Invoice;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('homepage');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/brand/edit', [BrandController::class, 'edit'])->name('brand.edit');
    Route::put('/brand/update', [BrandController::class, 'update'])->name('brand.update');

    Route::resource('/formats', InvoiceFormatController::class)->except(['show']);
    Route::resource('/invoices', InvoiceController::class)->except(['show']);
});
Route::get('/invoices/pdf/{invoice}', [InvoiceController::class, 'pdf'])->name('invoices.pdf');

require __DIR__.'/auth.php';
