<?php

namespace App\Filament\Resources\Kendaraans\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class KendaraanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Data Kendaraan')
                    ->description('Informasi identitas kendaraan.')
                    ->icon('heroicon-o-truck')
                    ->columns(2)
                    ->schema([
                        TextInput::make('plat_nomor')
                            ->label('Plat Nomor')
                            ->placeholder('Contoh: D 1234 XYZ')
                            ->required()
                            ->maxLength(20)
                            ->unique(ignoreRecord: true)
                            ->dehydrateStateUsing(fn($state) => strtoupper(trim($state)))
                            ->columnSpan(2),

                        Select::make('jenis_kendaraan')
                            ->label('Jenis Kendaraan')
                            ->options([
                                'motor' => ' Motor',
                                'mobil' => ' Mobil',
                            ])
                            ->required()
                            ->searchable()
                            ->preload()
                            ->reactive()
                            ->columnSpan(1),

                        TextInput::make('warna')
                            ->label('Warna')
                            ->placeholder('Contoh: Merah, Hitam, Putih')
                            ->required()
                            ->maxLength(50)
                            ->columnSpan(1),
                    ]),

                Section::make('Data Pemilik')
                    ->description('Informasi pemilik kendaraan.')
                    ->icon('heroicon-o-user')
                    ->schema([
                        TextInput::make('pemilik')
                            ->label('Nama Pemilik')
                            ->placeholder('Masukkan nama lengkap pemilik')
                            ->required()
                            ->maxLength(255),
                    ]),
            ]);
    }
}
