<?php

namespace App\Filament\Resources\Laporans\Tables;

use App\Models\Laporan;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class LaporansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('judul')
                    ->label('Judul Laporan')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->wrap(),

                TextColumn::make('periode_dari')
                    ->label('Periode')
                    ->formatStateUsing(fn(Laporan $record): string => $record->periode_format)
                    ->sortable(),

                TextColumn::make('total_transaksi')
                    ->label('Transaksi')
                    ->numeric()
                    ->sortable()
                    ->alignCenter(),

                TextColumn::make('total_pendapatan')
                    ->label('Pendapatan')
                    ->formatStateUsing(fn(Laporan $record): string => $record->total_pendapatan_format)
                    ->sortable()
                    ->color('success')
                    ->weight('bold'),

                TextColumn::make('areaParkir.nama_area')
                    ->label('Area')
                    ->default('Semua Area')
                    ->badge()
                    ->color('gray'),

                TextColumn::make('generated_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('generated_by')
                    ->label('Oleh')
                    ->default('—')
                    ->toggleable(isToggledHiddenByDefault: true),

            ])

            ->defaultSort('generated_at', 'desc')

            ->filters([

                SelectFilter::make('area_id')
                    ->label('Area Parkir')
                    ->relationship('areaParkir', 'nama_area')
                    ->native(false),

            ])

            ->recordActions([
                Action::make('download_pdf')
                    ->label('PDF')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->url(fn(Laporan $record): string => route('laporan.pdf', $record->id))
                    ->openUrlInNewTab(),

                EditAction::make(),

                DeleteAction::make(),
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])

            ->emptyStateIcon('heroicon-o-document-chart-bar')
            ->emptyStateHeading('Belum Ada Laporan')
            ->emptyStateDescription('Buat laporan baru dengan menekan tombol "Buat Laporan" di atas.');
    }
}
