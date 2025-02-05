<?php

namespace App\Filament\Resources\DokumenResource\Pages;

use App\Filament\Resources\DokumenResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDokumen extends CreateRecord
{
    protected static string $resource = DokumenResource::class;
    protected function afterCreate(): void
    {
        // Record the activity
        activity()
            ->causedBy(auth()->user())
            ->performedOn($this->record)
            ->event('created')
            ->log('User ' . auth()->user()->name . ' membuat surat keterangan ' . $this->record->keterangan . ' untuk ' . $this->record->user->name);
    }

}
