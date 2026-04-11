<?php

namespace App\Filament\Resources\Kendaraans;

use App\Filament\Resources\Kendaraans\Pages\CreateKendaraan;
use App\Filament\Resources\Kendaraans\Pages\EditKendaraan;
use App\Filament\Resources\Kendaraans\Pages\ListKendaraans;
use App\Filament\Resources\Kendaraans\Pages\ViewKendaraan;
use App\Filament\Resources\Kendaraans\Schemas\KendaraanForm;
use App\Filament\Resources\Kendaraans\Schemas\KendaraanInfolist;
use App\Filament\Resources\Kendaraans\Tables\KendaraansTable;
use App\Models\Kendaraan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class KendaraanResource extends Resource
{
    protected static ?string $model = Kendaraan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Truck;

    protected static string|UnitEnum|null $navigationGroup = 'Manajemen Parkir';

    protected static ?string $recordTitleAttribute = 'plat_nomor';

    protected static ?string $navigationLabel = 'Kendaraan';

    protected static ?string $modelLabel = 'Kendaraan';

    protected static ?string $pluralModelLabel = 'Daftar Kendaraan';

    protected static ?string $slug = 'kendaraan';

    protected static ?int $navigationSort = 1;


    public static function getNavigationBadge(): ?string
    {
        // Tampilkan jumlah kendaraan yang sedang parkir
        return (string) static::getModel()::whereHas(
            'transaksis',
            fn($q) => $q->where('status', 'masuk')
        )->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'success';
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        return 'Kendaraan sedang parkir';
    }

    // ─── Resource setup ───────────────────────────────────

    public static function form(Schema $schema): Schema
    {
        return KendaraanForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return KendaraanInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KendaraansTable::configure($table);
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
            'index' => ListKendaraans::route('/'),
            'create' => CreateKendaraan::route('/create'),
            'view' => ViewKendaraan::route('/{record}'),
            'edit' => EditKendaraan::route('/{record}/edit'),
        ];
    }
}
