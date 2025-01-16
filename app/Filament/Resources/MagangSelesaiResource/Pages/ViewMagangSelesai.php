<?php

namespace App\Filament\Resources\MagangSelesaiResource\Pages;

use App\Filament\Resources\MagangSelesaiResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewMagangSelesai extends ViewRecord
{
    protected static string $resource = MagangSelesaiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
