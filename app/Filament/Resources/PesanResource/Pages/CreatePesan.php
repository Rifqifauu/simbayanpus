<?php

namespace App\Filament\Resources\PesanResource\Pages;

use App\Filament\Resources\PesanResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePesan extends CreateRecord
{
    protected function afterCreate(): void
    {
        // Record the activity
        activity()
            ->causedBy(auth()->user())
            ->performedOn($this->record)
            ->event('created')
            ->log('User ' . auth()->user()->name . ' membuat surat keterangan ' . $this->record->keterangan . ' untuk ' . $this->record->user->name);
    }
    protected static string $resource = PesanResource::class;
}

