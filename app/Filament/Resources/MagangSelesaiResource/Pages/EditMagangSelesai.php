<?php

namespace App\Filament\Resources\MagangSelesaiResource\Pages;

use App\Filament\Resources\MagangSelesaiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMagangSelesai extends EditRecord
{
    protected static string $resource = MagangSelesaiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
