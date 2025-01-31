<?php

namespace App\Filament\Resources\DokumenResource\Pages;

use App\Filament\Resources\DokumenResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Pages\Actions\Action;


class EditDokumen extends EditRecord
{
    protected static string $resource = DokumenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Kembali')
                ->icon('heroicon-o-arrow-left')
                ->color('gray')
                ->url(url()->previous()), // Mengarahkan ke halaman sebelumnya
        ];
    }
}
