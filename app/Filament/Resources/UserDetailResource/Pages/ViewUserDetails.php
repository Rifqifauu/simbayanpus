<?php

namespace App\Filament\Resources\UserDetailResource\Pages;

use App\Filament\Resources\UserDetailResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;

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
}
