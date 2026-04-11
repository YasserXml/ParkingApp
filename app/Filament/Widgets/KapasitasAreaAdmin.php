<?php

namespace App\Filament\Widgets;

use App\Models\AreaParkir;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\Widget;

class KapasitasAreaAdmin extends Widget
{
    use HasWidgetShield;

    protected string $view = 'filament.widgets.kapasitas-area-admin';

    protected static ?int $sort = 4;

    public function getAreaParkirsProperty()
    {
        return AreaParkir::all();
    }
}
