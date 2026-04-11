<?php

namespace App\Filament\Widgets;

use App\Models\Transaksi;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewPetugas extends StatsOverviewWidget
{
    use HasWidgetShield;

    protected static ?int $sort = 1;

    protected int|string|array $columnSpan = 'full';

    protected function getStats(): array
    {
        $sedangParkir  = Transaksi::aktif()->count();
        $masukHariIni  = Transaksi::hariIni()->count();
        $keluarHariIni = Transaksi::selesai()->hariIni()->count();

        return [
            Stat::make('Sedang Parkir', $sedangParkir)
                ->description('Kendaraan aktif saat ini')
                ->descriptionIcon('heroicon-o-truck')
                ->color('success')
                ->chart([
                    $sedangParkir,
                ]),

            Stat::make('Masuk Hari Ini', $masukHariIni)
                ->description('Total kendaraan masuk')
                ->descriptionIcon('heroicon-o-arrow-down-tray')
                ->color('info'),

            Stat::make('Keluar Hari Ini', $keluarHariIni)
                ->description('Total kendaraan keluar')
                ->descriptionIcon('heroicon-o-arrow-up-tray')
                ->color('warning'),
        ];
    }
}
