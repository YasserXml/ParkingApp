<?php

namespace App\Filament\Resources\Kendaraans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class KendaraansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('plat_nomor')
                    ->label('Plat Nomor')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->formatStateUsing(fn(string $state) => strtoupper($state))
                    ->copyable()
                    ->copyMessage('Plat nomor disalin!'),

                TextColumn::make('jenis_kendaraan')
                    ->label('Jenis')
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'motor' => '🛵 Motor',
                        'mobil' => '🚗 Mobil',
                        default => ucfirst($state),
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'motor' => 'warning',
                        'mobil' => 'info',
                        default => 'gray',
                    }),

                TextColumn::make('warna')
                    ->label('Warna')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('pemilik')
                    ->label('Pemilik')
                    ->searchable()
                    ->sortable()
                    ->description(fn($record) => 'Total transaksi: ' . $record->transaksis()->count()),

                IconColumn::make('sedang_parkir')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-minus-circle')
                    ->trueColor('success')
                    ->falseColor('gray')
                    ->getStateUsing(fn($record) => $record->sedang_parkir)
                    ->tooltip(
                        fn($record) => $record->sedang_parkir
                            ? 'Sedang parkir'
                            : 'Tidak sedang parkir'
                    ),

                TextColumn::make('transaksis_count')
                    ->label('Total Transaksi')
                    ->counts('transaksis')
                    ->sortable()
                    ->alignCenter()
                    ->badge()
                    ->color('gray'),

                TextColumn::make('created_at')
                    ->label('Didaftarkan')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('jenis_kendaraan')
                    ->label('Jenis Kendaraan')
                    ->options([
                        'motor' => 'Motor',
                        'mobil' => 'Mobil',
                    ]),
            ])
            ->recordActions([
                ViewAction::make()
                    ->label('Lihat'),
                EditAction::make()
                    ->label('Edit'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Hapus Terpilih'),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->emptyStateIcon('heroicon-o-truck')
            ->emptyStateHeading('Belum ada kendaraan')
            ->emptyStateDescription('Kendaraan akan otomatis terdaftar saat pertama kali masuk parkir.');
    }
}
