<?php

namespace App\Filament\Widgets;

use App\Models\Transaksi;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewOwner extends StatsOverviewWidget
{
    use HasWidgetShield;

    protected static ?int $sort = 1;

    protected int|string|array $columnSpan = 'full';

    protected function getStats(): array
    {
        $pendapatanHariIni  = Transaksi::selesai()->hariIni()->sum('total_bayar');
        $pendapatanBulanIni = Transaksi::selesai()
            ->whereMonth('waktu_masuk', now()->month)
            ->whereYear('waktu_masuk', now()->year)
            ->sum('total_bayar');

        $totalTransaksiBulanIni = Transaksi::whereMonth('waktu_masuk', now()->month)
            ->whereYear('waktu_masuk', now()->year)
            ->count();

        $rataRataDurasi = Transaksi::selesai()
            ->whereMonth('waktu_masuk', now()->month)
            ->whereYear('waktu_masuk', now()->year)
            ->get()
            ->avg(fn($t) => $t->durasi_menit) ?? 0;

        $rataRataJam   = intdiv((int) $rataRataDurasi, 60);
        $rataRataMenit = (int) $rataRataDurasi % 60;
        $rataRataStr   = $rataRataJam > 0
            ? "{$rataRataJam}j {$rataRataMenit}m"
            : "{$rataRataMenit} menit";

        return [
            Stat::make('Pendapatan Hari Ini', 'Rp ' . number_format($pendapatanHariIni, 0, ',', '.'))
                ->description('Dari transaksi selesai hari ini')
                ->descriptionIcon('heroicon-o-banknotes')
                ->color('success'),

            Stat::make('Pendapatan Bulan Ini', 'Rp ' . number_format($pendapatanBulanIni, 0, ',', '.'))
                ->description('Total bulan ' . now()->translatedFormat('F Y'))
                ->descriptionIcon('heroicon-o-chart-bar')
                ->color('info'),

            Stat::make('Transaksi Bulan Ini', $totalTransaksiBulanIni)
                ->description('Total kendaraan masuk bulan ini')
                ->descriptionIcon('heroicon-o-ticket')
                ->color('warning'),

            Stat::make('Rata-rata Durasi', $rataRataStr)
                ->description('Rata-rata parkir per kendaraan')
                ->descriptionIcon('heroicon-o-clock')
                ->color('gray'),
        ];
    }
}
