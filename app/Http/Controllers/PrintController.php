<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class PrintController extends Controller
{
    /**
     * Cetak tiket masuk.
     * Dipanggil setelah kendaraan masuk berhasil disimpan.
     */
    public function tiket(Transaksi $transaksi)
    {
        $transaksi->load(['kendaraan', 'areaParkir']);

        return view('print.tiket', compact('transaksi'));
    }

    /**
     * Cetak struk keluar.
     * Dipanggil setelah kendaraan keluar berhasil diproses.
     */
    public function struk(Transaksi $transaksi)
    {
        $transaksi->load(['kendaraan', 'areaParkir']);

        return view('print.struk', compact('transaksi'));
    }
}
