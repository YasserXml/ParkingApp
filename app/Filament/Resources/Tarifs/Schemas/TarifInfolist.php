<?php

namespace App\Filament\Resources\Tarifs\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TarifInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Tarif')
                    ->icon('heroicon-o-banknotes')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('areaParkir.nama_area')
                            ->label('Area Parkir')
                            ->weight('bold')
                            ->icon('heroicon-o-map-pin'),

                        TextEntry::make('jenis_kendaraan')
                            ->label('Jenis Kendaraan')
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

                        TextEntry::make('tarif_per_jam')
                            ->label('Tarif per Jam')
                            ->money('IDR')
                            ->size('lg')
                            ->weight('bold')
                            ->color('success')
                            ->columnSpan(2),
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
