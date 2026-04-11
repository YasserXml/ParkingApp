<?php

namespace App\Filament\Resources\Tarifs\Schemas;

use App\Models\Tarif;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TarifForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Tarif')
                    ->description('Setiap kombinasi area dan jenis kendaraan hanya boleh memiliki satu tarif.')
                    ->icon('heroicon-o-banknotes')
                    ->columns(2)
                    ->schema([
                        Select::make('area_id')
                            ->label('Area Parkir')
                            ->relationship('areaParkir', 'nama_area')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->reactive()
                            ->columnSpan(1),

                        Select::make('jenis_kendaraan')
                            ->label('Jenis Kendaraan')
                            ->options([
                                'motor' => ' Motor',
                                'mobil' => ' Mobil',
                            ])
                            ->required()
                            ->reactive()
                            ->columnSpan(1)
                            ->rules([
                                fn($get, $livewire): \Closure => function (
                                    string $attribute,
                                    $value,
                                    \Closure $fail
                                ) use ($get, $livewire) {
                                    $areaId = $get('area_id');

                                    if (! $areaId || ! $value) {
                                        return;
                                    }

                                    // Saat edit, abaikan record yang sedang diedit
                                    $recordId = $livewire->record?->id;

                                    $sudahAda = Tarif::where('area_id', $areaId)
                                        ->where('jenis_kendaraan', $value)
                                        ->when($recordId, fn($q) => $q->where('id', '!=', $recordId))
                                        ->exists();

                                    if ($sudahAda) {
                                        $fail('Tarif untuk area dan jenis kendaraan ini sudah ada.');
                                    }
                                },
                            ]),

                        TextInput::make('tarif_per_jam')
                            ->label('Tarif per Jam (Rp)')
                            ->placeholder('Contoh: 5000')
                            ->numeric()
                            ->required()
                            ->minValue(0)
                            ->prefix('Rp')
                            ->suffix('/jam')
                            ->columnSpan(2),
                    ]),
            ]);
    }
}
