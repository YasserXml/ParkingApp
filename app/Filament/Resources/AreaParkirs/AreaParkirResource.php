<?php

namespace App\Filament\Resources\AreaParkirs;

use App\Filament\Resources\AreaParkirs\Pages\CreateAreaParkir;
use App\Filament\Resources\AreaParkirs\Pages\EditAreaParkir;
use App\Filament\Resources\AreaParkirs\Pages\ListAreaParkirs;
use App\Filament\Resources\AreaParkirs\Pages\ViewAreaParkir;
use App\Filament\Resources\AreaParkirs\Schemas\AreaParkirForm;
use App\Filament\Resources\AreaParkirs\Schemas\AreaParkirInfolist;
use App\Filament\Resources\AreaParkirs\Tables\AreaParkirsTable;
use App\Models\AreaParkir;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class AreaParkirResource extends Resource
{
    protected static ?string $model = AreaParkir::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::MapPin;

    protected static string|UnitEnum|null $navigationGroup = 'Manajemen Parkir';

    protected static ?string $recordTitleAttribute = 'nama_area';

    protected static ?string $navigationLabel = 'Area Parkir';

    protected static ?string $modelLabel = 'Area Parkir';

    protected static ?string $pluralModelLabel = 'Daftar Area Parkir';

    protected static ?string $slug = 'area-parkir';

    protected static ?int $navigationSort = 2;


    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }


    public static function form(Schema $schema): Schema
    {
        return AreaParkirForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AreaParkirInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AreaParkirsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAreaParkirs::route('/'),
            'create' => CreateAreaParkir::route('/create'),
            'view' => ViewAreaParkir::route('/{record}'),
            'edit' => EditAreaParkir::route('/{record}/edit'),
        ];
    }
}
