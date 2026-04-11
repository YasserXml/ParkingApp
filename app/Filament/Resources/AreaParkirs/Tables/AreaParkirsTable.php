<?php

namespace App\Filament\Resources\AreaParkirs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Table;

class AreaParkirsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_area')
                    ->label('Nama Area')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('kapasitas')
                    ->label('Kapasitas')
                    ->sortable()
                    ->alignCenter()
                    ->suffix(' slot'),

                TextColumn::make('terisi')
                    ->label('Terisi')
                    ->sortable()
                    ->alignCenter()
                    ->suffix(' kendaraan'),

                // Progress bar kapasitas
                ViewColumn::make('persentase_terisi')
                    ->label('Kepadatan')
                    ->view('areaparkir.kapasitas-progress'),

                TextColumn::make('status_kepadatan')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'tersedia' => 'Tersedia',
                        'padat'    => 'Padat',
                        'penuh'    => 'Penuh',
                        default    => ucfirst($state),
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'tersedia' => 'success',
                        'padat'    => 'warning',
                        'penuh'    => 'danger',
                        default    => 'gray',
                    })
                    ->getStateUsing(fn($record) => $record->status_kepadatan),

                TextColumn::make('sisa_slot')
                    ->label('Sisa Slot')
                    ->alignCenter()
                    ->getStateUsing(fn($record) => $record->sisa_slot)
                    ->suffix(' slot')
                    ->color(fn($record): string => match (true) {
                        $record->sisa_slot === 0        => 'danger',
                        $record->sisa_slot <= 5         => 'warning',
                        default                         => 'success',
                    }),

                TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
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
            ->defaultSort('nama_area', 'asc')
            ->striped()
            ->emptyStateIcon('heroicon-o-map-pin')
            ->emptyStateHeading('Belum ada area parkir')
            ->emptyStateDescription('Tambahkan area parkir terlebih dahulu.');
    }
}
