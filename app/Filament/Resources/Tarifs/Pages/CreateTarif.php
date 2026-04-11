<?php

namespace App\Filament\Resources\Tarifs\Pages;

use App\Filament\Resources\Tarifs\TarifResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateTarif extends CreateRecord
{
    protected static string $resource = TarifResource::class;

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Data Tarif Parkir berhasil ditambahkan';
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Kembali')
                ->icon('heroicon-o-arrow-left')
                ->url(static::getResource()::getUrl('index')),
        ];
    }
    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction()
                ->label('Buat Tarif Parkir')
                ->icon('heroicon-o-check')
                ->size('lg')
                ->extraAttributes([
                    'class' => 'font-semibold',
                ]),

            $this->getCreateAnotherFormAction()
                ->label('Buat & Tambah Lagi')
                ->icon('heroicon-o-plus-circle')
                ->color('gray'),

            $this->getCancelFormAction()
                ->label('Batal')
                ->icon('heroicon-o-x-mark')
                ->color('gray'),
        ];
    }
}
