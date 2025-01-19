<?php

namespace App\Filament\Resources\MagangAktifResource\Pages;

use App\Filament\Resources\MagangAktifResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;

class ViewMagangAktif extends ViewRecord
{
    protected static string $resource = MagangAktifResource::class;
    public function getTitle(): string 
    {
        return 'Detail Magang Aktif';
    }
    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
            ->label('Back')
            ->url(url()->previous())        ];
    }
}
