<?php

namespace App\Filament\Resources\Laporans\Schemas;

use App\Models\AreaParkir;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class LaporanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            Section::make('Identitas Laporan')
                ->description('Judul dan area laporan.')
                ->icon('heroicon-o-document-text')
                ->schema([

                    TextInput::make('judul')
                        ->label('Judul Laporan')
                        ->placeholder('Contoh: Laporan Parkir April 2025')
                        ->required()
                        ->maxLength(255)
                        ->columnSpanFull(),

                    Select::make('area_id')
                        ->label('Area Parkir')
                        ->placeholder('Semua area')
                        ->options(AreaParkir::pluck('nama_area', 'id'))
                        ->nullable()
                        ->native(false)
                        ->helperText('Kosongkan untuk merekap semua area sekaligus.'),

                ])->columns(2),

            Section::make('Rentang Periode')
                ->description('Tentukan periode data yang akan direkap.')
                ->icon('heroicon-o-calendar-days')
                ->schema([

                    DatePicker::make('periode_dari')
                        ->label('Dari Tanggal')
                        ->required()
                        ->default(today()->startOfMonth())
                        ->maxDate(today())
                        ->native(false)
                        ->displayFormat('d M Y'),

                    DatePicker::make('periode_sampai')
                        ->label('Sampai Tanggal')
                        ->required()
                        ->default(today())
                        ->maxDate(today())
                        ->native(false)
                        ->displayFormat('d M Y')
                        ->afterOrEqual('periode_dari'),

                ])->columns(2),

        ]);
    }
}
