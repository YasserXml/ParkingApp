<?php

namespace App\Filament\Widgets;

use App\Models\AreaParkir;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\Widget;

class KapasitasAreaPetugas extends Widget
{
    use HasWidgetShield;

    protected string $view = 'filament.widgets.kapasitas-area-petugas';

    protected static ?int $sort = 5;

    public function getAreaParkirsProperty()
    {
        return AreaParkir::all();
    }
}
