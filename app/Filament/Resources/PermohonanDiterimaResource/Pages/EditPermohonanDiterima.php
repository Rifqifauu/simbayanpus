<?php

namespace App\Filament\Resources\PermohonanDiterimaResource\Pages;

use App\Filament\Resources\PermohonanDiterimaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPermohonanDiterima extends EditRecord
{
    protected static string $resource = PermohonanDiterimaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
