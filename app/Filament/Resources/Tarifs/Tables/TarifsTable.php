<?php

namespace App\Filament\Resources\Tarifs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class TarifsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('areaParkir.nama_area')
                    ->label('Area Parkir')
                    ->sortable()
                    ->searchable()
                    ->weight('bold'),

                TextColumn::make('jenis_kendaraan')
                    ->label('Jenis Kendaraan')
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'motor' => ' Motor',
                        'mobil' => ' Mobil',
                        default => ucfirst($state),
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'motor' => 'warning',
                        'mobil' => 'info',
                        default => 'gray',
                    }),

                TextColumn::make('tarif_per_jam')
                    ->label('Tarif per Jam')
                    ->money('IDR')
                    ->sortable(),

                TextColumn::make('updated_at')
                    ->label('Terakhir Diubah')
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('area_id')
                    ->label('Area Parkir')
                    ->relationship('areaParkir', 'nama_area')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('jenis_kendaraan')
                    ->label('Jenis Kendaraan')
                    ->options([
                        'motor' => ' Motor',
                        'mobil' => ' Mobil',
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
            ->defaultSort('area_id', 'asc')
            ->groups([
                'areaParkir.nama_area',
            ])
            ->defaultGroup('areaParkir.nama_area')
            ->striped()
            ->emptyStateIcon('heroicon-o-banknotes')
            ->emptyStateHeading('Belum ada tarif')
            ->emptyStateDescription('Tambahkan tarif untuk setiap area dan jenis kendaraan.');
    }
}
