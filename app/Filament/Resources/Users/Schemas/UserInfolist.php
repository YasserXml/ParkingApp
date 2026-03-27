<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Akun')
                    ->description('Detail lengkap akun pengguna.')
                    ->icon('heroicon-o-user-circle')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('id')
                            ->label('ID Pengguna')
                            ->badge()
                            ->color('gray'),

                        TextEntry::make('name')
                            ->label('Nama Lengkap')
                            ->weight('bold')
                            ->size('lg'),

                        TextEntry::make('email')
                            ->label('Alamat Email')
                            ->copyable()
                            ->copyMessage('Email disalin!')
                            ->icon('heroicon-o-envelope')
                            ->columnSpan(2),
                    ]),

                Section::make('Riwayat')
                    ->description('Informasi waktu akun dibuat dan diperbarui.')
                    ->icon('heroicon-o-clock')
                    ->columns(2)
                    ->collapsed()
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Dibuat Pada')
                            ->dateTime('d M Y, H:i')
                            ->since()
                            ->icon('heroicon-o-plus-circle'),

                        TextEntry::make('updated_at')
                            ->label('Terakhir Diperbarui')
                            ->dateTime('d M Y, H:i')
                            ->since()
                            ->icon('heroicon-o-pencil-square'),
                    ]),
            ]);
    }
}
