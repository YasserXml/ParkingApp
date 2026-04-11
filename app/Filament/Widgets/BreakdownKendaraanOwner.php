<?php

namespace App\Filament\Widgets;

use App\Models\Transaksi;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\ChartWidget;

class BreakdownKendaraanOwner extends ChartWidget
{
    use HasWidgetShield;

    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = 1;

    protected function getData(): array
    {
        $motor = Transaksi::selesai()
            ->whereMonth('waktu_masuk', now()->month)
            ->whereYear('waktu_masuk', now()->year)
            ->whereHas('kendaraan', fn($q) => $q->where('jenis_kendaraan', 'motor'))
            ->count();

        $mobil = Transaksi::selesai()
            ->whereMonth('waktu_masuk', now()->month)
            ->whereYear('waktu_masuk', now()->year)
            ->whereHas('kendaraan', fn($q) => $q->where('jenis_kendaraan', 'mobil'))
            ->count();

        $pendapatanMotor = Transaksi::selesai()
            ->whereMonth('waktu_masuk', now()->month)
            ->whereYear('waktu_masuk', now()->year)
            ->whereHas('kendaraan', fn($q) => $q->where('jenis_kendaraan', 'motor'))
            ->sum('total_bayar');

        $pendapatanMobil = Transaksi::selesai()
            ->whereMonth('waktu_masuk', now()->month)
            ->whereYear('waktu_masuk', now()->year)
            ->whereHas('kendaraan', fn($q) => $q->where('jenis_kendaraan', 'mobil'))
            ->sum('total_bayar');

        return [
            'datasets' => [
                [
                    'label'           => 'Jumlah Transaksi',
                    'data'            => [$motor, $mobil],
                    'backgroundColor' => ['#fde047', '#60a5fa'],
                    'borderColor'     => ['#000', '#000'],
                    'borderWidth'     => 2,
                    'hoverOffset'     => 4,
                ],
            ],
            'labels' => [
                "🛵 Motor ({$motor} transaksi · Rp " . number_format($pendapatanMotor, 0, ',', '.') . ')',
                "🚗 Mobil ({$mobil} transaksi · Rp " . number_format($pendapatanMobil, 0, ',', '.') . ')',
            ],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'position' => 'bottom',
                    'labels'   => [
                        'padding'   => 20,
                        'boxWidth'  => 14,
                    ],
                ],
            ],
            'cutout' => '65%',
        ];
    }
}
