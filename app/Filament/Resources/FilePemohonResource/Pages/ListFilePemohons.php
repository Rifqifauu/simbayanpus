<?php

namespace App\Filament\Resources\FilePemohonResource\Pages;

use App\Filament\Resources\FilePemohonResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFilePemohons extends ListRecords
{
    protected static string $resource = FilePemohonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
