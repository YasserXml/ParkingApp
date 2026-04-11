<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LaporanPdfController extends Controller
{
    /**
     * Tampilkan halaman PDF laporan.
     * Halaman ini dirancang untuk langsung di-print / Save as PDF via browser.
     * Tidak memerlukan library tambahan seperti DomPDF.
     */
    public function show(Laporan $laporan): Response
    {
        // Load relasi yang dibutuhkan template
        $laporan->loadMissing('areaParkir');

        return response()->view('pdf.laporan', [
            'laporan' => $laporan,
        ])->header('Content-Type', 'text/html');
    }
}
