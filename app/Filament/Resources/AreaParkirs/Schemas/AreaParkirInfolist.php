<?php

namespace App\Filament\Resources\AreaParkirs\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AreaParkirInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Area Parkir')
                    ->icon('heroicon-o-map-pin')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('nama_area')
                            ->label('Nama Area')
                            ->weight('bold')
                            ->size('lg')
                            ->columnSpan(2),

                        TextEntry::make('kapasitas')
                            ->label('Kapasitas Total')
                            ->suffix(' slot')
                            ->icon('heroicon-o-squares-2x2'),

                        TextEntry::make('terisi')
                            ->label('Saat Ini Terisi')
                            ->suffix(' kendaraan')
                            ->icon('heroicon-o-truck'),

                        TextEntry::make('sisa_slot')
                            ->label('Sisa Slot')
                            ->suffix(' slot')
                            ->getStateUsing(fn($record) => $record->sisa_slot)
                            ->color(fn($record): string => match (true) {
                                $record->sisa_slot === 0   => 'danger',
                                $record->sisa_slot <= 5    => 'warning',
                                default                    => 'success',
                            })
                            ->weight('bold'),

                        TextEntry::make('status_kepadatan')
                            ->label('Status')
                            ->badge()
                            ->getStateUsing(fn($record) => $record->status_kepadatan)
                            ->formatStateUsing(fn(string $state): string => match ($state) {
                                'tersedia' => 'Tersedia',
                                'padat'    => 'Padat',
                                'penuh'    => 'Penuh',
                                default    => ucfirst($state),
                            })
                            ->color(fn($record): string => $record->status_color),
                    ]),

                Section::make('Kepadatan')
                    ->icon('heroicon-o-chart-bar')
                    ->schema([
                        ViewEntry::make('kapasitas_progress')
                            ->label('Tingkat Kepadatan')
                            ->view('areaparkir.infolist-kapasitas-progress'),
                    ]),

                Section::make('Riwayat')
                    ->icon('heroicon-o-clock')
                    ->columns(2)
                    ->collapsed()
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Dibuat Pada')
                            ->dateTime('d M Y, H:i')
                            ->since(),

                        TextEntry::make('updated_at')
                            ->label('Terakhir Diubah')
                            ->dateTime('d M Y, H:i')
                            ->since(),
                    ]),
            ]);
    }
}
