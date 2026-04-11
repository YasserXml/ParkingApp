<?php

namespace App\Filament\Widgets;

use App\Models\Transaksi as ModelsTransaksi;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Transaksi;

class TransaksiTerbaruAdmin extends TableWidget
{
    use HasWidgetShield;

    protected static ?int $sort = 5;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                ModelsTransaksi::with(['kendaraan', 'areaParkir'])
                    ->latest('waktu_masuk')
            )
            ->columns([
                TextColumn::make('kendaraan.plat_nomor')
                    ->label('Plat Nomor')
                    ->weight('bold')
                    ->formatStateUsing(fn($state) => strtoupper($state))
                    ->searchable(),

                TextColumn::make('kendaraan.jenis_kendaraan')
                    ->label('Jenis')
                    ->badge()
                    ->formatStateUsing(fn($state) => match ($state) {
                        'motor' => '🛵 Motor',
                        'mobil' => '🚗 Mobil',
                        default => ucfirst($state),
                    })
                    ->color(fn($state) => match ($state) {
                        'motor' => 'warning',
                        'mobil' => 'info',
                        default => 'gray',
                    }),

                TextColumn::make('areaParkir.nama_area')
                    ->label('Area'),

                TextColumn::make('waktu_masuk')
                    ->label('Masuk')
                    ->dateTime('H:i · d M'),

                TextColumn::make('waktu_keluar')
                    ->label('Keluar')
                    ->dateTime('H:i · d M')
                    ->placeholder('Masih parkir'),

                TextColumn::make('total_bayar')
                    ->label('Total')
                    ->money('IDR')
                    ->placeholder('—'),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn($state) => match ($state) {
                        'masuk'  => 'Parkir',
                        'keluar' => 'Selesai',
                        default  => ucfirst($state),
                    })
                    ->color(fn($state) => match ($state) {
                        'masuk'  => 'success',
                        'keluar' => 'gray',
                        default  => 'gray',
                    }),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'masuk'  => 'Sedang Parkir',
                        'keluar' => 'Selesai',
                    ]),
            ])
            ->emptyStateIcon('heroicon-o-receipt-percent')
            ->emptyStateHeading('Belum ada transaksi')
            ->paginated([10, 25, 50]);
    }
}
