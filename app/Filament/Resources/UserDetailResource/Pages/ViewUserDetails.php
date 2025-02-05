<?php

namespace App\Filament\Resources\UserDetailResource\Pages;

use App\Filament\Resources\UserDetailResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\View\View;

class ViewUserDetails extends ViewRecord
{
    protected static string $resource = UserDetailResource::class;
    
    public function getTitle(): string 
    {
        return 'Detail Pemohon';
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
