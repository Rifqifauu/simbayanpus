<?php

namespace App\Filament\Resources\UserDetailResource\Pages;

use App\Filament\Resources\UserDetailResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewUserDetails extends ViewRecord
{
    protected static string $resource = UserDetailResource::class;
    
    public function getTitle(): string 
    {
        return 'Detail Pemohon';
    }
}
