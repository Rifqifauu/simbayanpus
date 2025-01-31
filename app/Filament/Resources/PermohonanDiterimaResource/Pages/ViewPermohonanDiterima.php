<?php

namespace App\Filament\Resources\PermohonanDiterimaResource\Pages;

use App\Filament\Resources\PermohonanDiterimaResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;


class ViewPermohonanDiterima extends ViewRecord
{
    protected static string $resource = PermohonanDiterimaResource::class;
    
    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
            ->label('Back')
            ->url(url()->previous())        ];
    }
}
