<?php

namespace App\Filament\Resources\MagangAktifResource\Pages;

use Illuminate\View\View;
use App\Filament\Resources\MagangAktifResource;
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
    public function render(): View{
        activity()
        ->causedBy(auth()->user())
        ->performedOn($this->record)
        ->event('view')
        ->log('User ' . auth()->user()->name . ' viewed a record ' . $this->record->user->name);
        return parent::render();

    }
}
