<?php

namespace App\Filament\Resources\AreaParkirs\Pages;

use App\Filament\Resources\AreaParkirs\AreaParkirResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateAreaParkir extends CreateRecord
{
    protected static string $resource = AreaParkirResource::class;

     protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Pastikan terisi selalu dimulai dari 0 saat area baru dibuat
        $data['terisi'] = 0;

        return $data;
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Area parkir berhasil ditambahkan';
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
                ->label('Tambah Area Parkir')
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
