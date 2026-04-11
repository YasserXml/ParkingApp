<?php

namespace App\Filament\Widgets;

use App\Models\Transaksi as ModelsTransaksi;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Transaksi;

class Transaksiaktif extends TableWidget
{
    use HasWidgetShield;

    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                ModelsTransaksi::aktif()
                    ->with(['kendaraan', 'areaParkir'])
                    ->latest('waktu_masuk')
            )
            ->columns([
                TextColumn::make('kendaraan.plat_nomor')
                    ->label('Plat Nomor')
                    ->weight('bold')
                    ->formatStateUsing(fn ($state) => strtoupper($state))
                    ->searchable(),

                TextColumn::make('kendaraan.jenis_kendaraan')
                    ->label('Jenis')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'motor' => '🛵 Motor',
                        'mobil' => '🚗 Mobil',
                        default => ucfirst($state),
                    })
                    ->color(fn ($state) => match ($state) {
                        'motor' => 'warning',
                        'mobil' => 'info',
                        default => 'gray',
                    }),

                TextColumn::make('areaParkir.nama_area')
                    ->label('Area'),

                TextColumn::make('waktu_masuk')
                    ->label('Masuk')
                    ->dateTime('H:i · d M'),

                TextColumn::make('durasi_format')
                    ->label('Durasi')
                    ->getStateUsing(fn ($record) => $record->durasi_format),

                TextColumn::make('tarif')
                    ->label('Tarif/Jam')
                    ->money('IDR'),
            ])
            ->emptyStateIcon('heroicon-o-truck')
            ->emptyStateHeading('Tidak ada kendaraan parkir')
            ->emptyStateDescription('Semua kendaraan sudah keluar.')
            ->paginated([5, 10, 25]);
    }
}
