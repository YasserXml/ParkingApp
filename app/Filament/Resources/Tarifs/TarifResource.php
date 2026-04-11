<?php

namespace App\Filament\Resources\Tarifs;

use App\Filament\Resources\Tarifs\Pages\CreateTarif;
use App\Filament\Resources\Tarifs\Pages\EditTarif;
use App\Filament\Resources\Tarifs\Pages\ListTarifs;
use App\Filament\Resources\Tarifs\Pages\ViewTarif;
use App\Filament\Resources\Tarifs\Schemas\TarifForm;
use App\Filament\Resources\Tarifs\Schemas\TarifInfolist;
use App\Filament\Resources\Tarifs\Tables\TarifsTable;
use App\Models\Tarif;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class TarifResource extends Resource
{
    protected static ?string $model = Tarif::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Banknotes;

    protected static string|UnitEnum|null $navigationGroup = 'Manajemen Parkir';

    protected static ?string $recordTitleAttribute = 'jenis_kendaraan';

    protected static ?string $navigationLabel = 'Tarif Parkir';

    protected static ?string $modelLabel = 'Tarif';

    protected static ?string $pluralModelLabel = 'Daftar Tarif';

    protected static ?string $slug = 'tarif';

    protected static ?int $navigationSort = 3;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'primary';
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        return 'Total tarif terdaftar';
    }


    public static function form(Schema $schema): Schema
    {
        return TarifForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TarifInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TarifsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListTarifs::route('/'),
            'create' => CreateTarif::route('/create'),
            'view'   => ViewTarif::route('/{record}'),
            'edit'   => EditTarif::route('/{record}/edit'),
        ];
    }
}
