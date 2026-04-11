<?php

namespace App\Filament\Resources\Kendaraans\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class KendaraanInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Data Kendaraan')
                    ->icon('heroicon-o-truck')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('plat_nomor')
                            ->label('Plat Nomor')
                            ->weight('bold')
                            ->size('lg')
                            ->formatStateUsing(fn($state) => strtoupper($state))
                            ->copyable()
                            ->copyMessage('Plat nomor disalin!')
                            ->columnSpan(2),

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

                        TextEntry::make('warna')
                            ->label('Warna')
                            ->icon('heroicon-o-swatch'),
                    ]),

                Section::make('Data Pemilik')
                    ->icon('heroicon-o-user')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('pemilik')
                            ->label('Nama Pemilik')
                            ->weight('bold')
                            ->icon('heroicon-o-user-circle'),

                        IconEntry::make('sedang_parkir')
                            ->label('Status Parkir')
                            ->boolean()
                            ->trueIcon('heroicon-o-check-circle')
                            ->falseIcon('heroicon-o-minus-circle')
                            ->trueColor('success')
                            ->falseColor('gray')
                            ->getStateUsing(fn($record) => $record->sedang_parkir),

                        TextEntry::make('transaksis_count')
                            ->label('Total Transaksi')
                            ->getStateUsing(fn($record) => $record->transaksis()->count() . ' transaksi')
                            ->icon('heroicon-o-receipt-percent'),

                        TextEntry::make('created_at')
                            ->label('Pertama Didaftarkan')
                            ->dateTime('d M Y, H:i')
                            ->since()
                            ->icon('heroicon-o-calendar'),
                    ]),

                Section::make('Riwayat')
                    ->icon('heroicon-o-clock')
                    ->columns(2)
                    ->collapsed()
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Dibuat Pada')
                            ->dateTime('d M Y, H:i'),

                        TextEntry::make('updated_at')
                            ->label('Terakhir Diubah')
                            ->dateTime('d M Y, H:i'),
                    ]),
            ]);
    }
}
