<?php

namespace App\Filament\Resources\PermohonanDiterimaResource\Pages;

use App\Filament\Resources\PermohonanDiterimaResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\View\View;



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
    public function render(): View{
        activity()
        ->causedBy(auth()->user())
        ->performedOn($this->record)
        ->event('view')
        ->log('User ' . auth()->user()->name . ' viewed a record ' . $this->record->user->name);
        return parent::render();

    }
}
