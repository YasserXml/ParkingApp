<?php

namespace App\Filament\Resources\Laporans\Pages;

use App\Filament\Resources\Laporans\LaporanResource;
use App\Models\Transaksi;
use Carbon\Carbon;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateLaporan extends CreateRecord
{
    protected static string $resource = LaporanResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['jenis_laporan'] = 'custom';

        return $data;
    }

    protected function afterCreate(): void
    {
        /** @var Laporan $laporan */
        $laporan = $this->record;

        $dari   = Carbon::parse($laporan->periode_dari)->startOfDay();
        $sampai = Carbon::parse($laporan->periode_sampai)->endOfDay();

        // Query transaksi sesuai periode & area
        $query = Transaksi::with(['kendaraan', 'areaParkir'])
            ->whereBetween('waktu_masuk', [$dari, $sampai])
            ->when($laporan->area_id, fn($q) => $q->where('area_id', $laporan->area_id));

        $semuaTransaksi    = (clone $query)->get();
        $transaksiSelesai  = (clone $query)->where('status', 'keluar')->get();

        // ── Agregat utama ─────────────────────────────────────────────────
        $totalMasuk   = $semuaTransaksi->count();
        $totalKeluar  = $transaksiSelesai->count();
        $pendapatan   = (float) $transaksiSelesai->sum('total_bayar');
        $rataRata     = $transaksiSelesai->count() > 0
            ? $transaksiSelesai->avg(fn($t): int => $t->durasi_menit)
            : 0;

        // ── Ringkasan per jenis kendaraan ──────────────────────────────────
        $jenisKendaraan = $semuaTransaksi
            ->groupBy(fn($t) => $t->kendaraan?->jenis_kendaraan ?? 'unknown')
            ->map(fn($grup, $jenis) => [
                'masuk'      => $grup->count(),
                'keluar'     => $grup->where('status', 'keluar')->count(),
                'pendapatan' => (float) $grup->where('status', 'keluar')->sum('total_bayar'),
            ])
            ->toArray();

        // ── Ringkasan per area (hanya jika laporan semua area) ─────────────
        $perArea = null;
        if (! $laporan->area_id) {
            $perArea = $transaksiSelesai
                ->groupBy('area_id')
                ->map(fn($grup) => [
                    'area_id'         => $grup->first()->area_id,
                    'nama_area'       => $grup->first()->areaParkir?->nama_area ?? '-',
                    'total_transaksi' => $grup->count(),
                    'pendapatan'      => (float) $grup->sum('total_bayar'),
                ])
                ->values()
                ->toArray();
        }

        // ── Simpan kalkulasi ke record ─────────────────────────────────────
        $laporan->update([
            'total_transaksi'         => $totalMasuk,
            'total_kendaraan_masuk'   => $totalMasuk,
            'total_kendaraan_keluar'  => $totalKeluar,
            'total_pendapatan'        => $pendapatan,
            'rata_rata_durasi_menit'  => round($rataRata, 2),
            'ringkasan_per_jenis'     => $jenisKendaraan,
            'ringkasan_per_area'      => $perArea,
            'generated_at'            => now(),
            'generated_by'            => Auth::user()?->name ?? 'system',
        ]);

        Notification::make()
            ->title('Laporan berhasil dibuat')
            ->body("Ditemukan {$totalMasuk} transaksi, pendapatan: Rp " . number_format($pendapatan, 0, ',', '.'))
            ->success()
            ->send();
    }
}
