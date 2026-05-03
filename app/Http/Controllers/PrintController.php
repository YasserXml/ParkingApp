<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PrintController extends Controller
{
    public function tiket(Transaksi $transaksi)
    {
        $transaksi->load(['kendaraan', 'areaParkir']);

        $pdf = Pdf::loadView('print.tiket', compact('transaksi'))
            ->setPaper([0, 0, 595, 420], 'landscape') // ukuran tiket landscape
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled'      => true,
                'defaultFont'          => 'sans-serif',
            ]);

        return $pdf->stream("tiket-{$transaksi->kendaraan->plat_nomor}.pdf");
    }

    public function struk(Transaksi $transaksi)
    {
        $transaksi->load(['kendaraan', 'areaParkir']);

        $pdf = Pdf::loadView('print.struk', compact('transaksi'))

            ->setPaper([0, 0, 226, 500], 'portrait') // ukuran struk thermal
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled'      => true,
                'defaultFont'          => 'sans-serif',
            ]);

        return $pdf->stream("struk-{$transaksi->kendaraan->plat_nomor}.pdf");
    }
}
