<?php

namespace App\Filament\Resources\AreaParkirs\Schemas;

use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AreaParkirForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Area Parkir')
                    ->description('Data dasar area parkir. Jumlah terisi dikelola otomatis oleh sistem.')
                    ->icon('heroicon-o-map-pin')
                    ->columns(2)
                    ->schema([
                        TextInput::make('nama_area')
                            ->label('Nama Area')
                            ->placeholder('Contoh: Area A, Lantai 1, Basement')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(2),

                        TextInput::make('kapasitas')
                            ->label('Kapasitas Total')
                            ->placeholder('Contoh: 50')
                            ->numeric()
                            ->required()
                            ->minValue(1)
                            ->suffix('slot')
                            ->helperText('Jumlah maksimal kendaraan yang bisa ditampung.')
                            ->columnSpan(1),

                        // Kolom terisi hanya tampil saat edit, readonly
                        Placeholder::make('terisi')
                            ->label('Saat Ini Terisi')
                            ->content(
                                fn($record) => $record
                                    ? ($record->terisi ?? 0) . ' kendaraan'
                                    : '—'
                            )
                            ->helperText('Dikelola otomatis oleh sistem, tidak bisa diubah manual.')
                            ->columnSpan(1)
                            ->visible(fn(string $operation) => $operation === 'edit'),
                    ]),
            ]);
    }
}
