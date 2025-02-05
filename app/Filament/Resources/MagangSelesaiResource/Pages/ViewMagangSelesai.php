<?php

namespace App\Filament\Resources\MagangSelesaiResource\Pages;

use App\Filament\Resources\MagangSelesaiResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\View\View;

class ViewMagangSelesai extends ViewRecord
{
    protected static string $resource = MagangSelesaiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
    public function render(): View{
        activity()
        ->causedBy(auth()->user())
        ->performedOn($this->record)
        ->event('view')
        ->log('User ' . auth()->user()->name . ' viewed a record ' . $this->record->user->name);
        return parent::render();

    }
}
