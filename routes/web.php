<?php

use App\Http\Controllers\LaporanPdfController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/park');
});

Route::get('/print/tiket/{transaksi}', [App\Http\Controllers\PrintController::class, 'tiket'])
    ->name('print.tiket')
    ->middleware('auth');

Route::get('/print/struk/{transaksi}', [App\Http\Controllers\PrintController::class, 'struk'])
    ->name('print.struk')
    ->middleware('auth');

Route::middleware(['auth'])->group(function () {

    // PDF Laporan — buka di tab baru, trigger browser print
    Route::get('/laporan/{laporan}/pdf', [LaporanPdfController::class, 'show'])
        ->name('laporan.pdf');

});
