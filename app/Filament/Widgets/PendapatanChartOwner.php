<?php

namespace App\Filament\Widgets;

use App\Models\Transaksi;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\ChartWidget;

class PendapatanChartOwner extends ChartWidget
{
    use HasWidgetShield;

    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 1;

    protected function getData(): array
    {
        $labels    = [];
        $data      = [];

        for ($i = 6; $i >= 0; $i--) {
            $tanggal = now()->subDays($i);

            $labels[] = $tanggal->translatedFormat('d M');

            $pendapatan = Transaksi::selesai()
                ->whereDate('waktu_keluar', $tanggal->toDateString())
                ->sum('total_bayar');

            $data[] = (float) $pendapatan;
        }

        return [
            'datasets' => [
                [
                    'label'           => 'Pendapatan (Rp)',
                    'data'            => $data,
                    'borderColor'     => '#4ade80',
                    'backgroundColor' => 'rgba(74, 222, 128, 0.15)',
                    'borderWidth'     => 2,
                    'tension'         => 0.4,
                    'fill'            => true,
                    'pointBackgroundColor' => '#000',
                    'pointBorderColor'     => '#4ade80',
                    'pointRadius'          => 4,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => ['display' => false],
                'tooltip' => [
                    'callbacks' => [
                        'label' => 'function(context) {
                            return "Rp " + context.parsed.y.toLocaleString("id-ID");
                        }',
                    ],
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks'       => [
                        'callback' => 'function(value) {
                            return "Rp " + value.toLocaleString("id-ID");
                        }',
                    ],
                ],
            ],
        ];
    }
}
