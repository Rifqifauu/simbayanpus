<?php

namespace App\Filament\Resources\NilaiResource\Pages;

use App\Filament\Resources\NilaiResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateNilai extends CreateRecord
{
    protected static string $resource = NilaiResource::class;

    protected function afterCreate(): void
    {
        $user = auth()->user();
        $dokumen = $this->record;

        activity()
            ->causedBy($user)
            ->performedOn($dokumen)
            ->event('created')
            ->log('User ' . $user->name . ' membuat dokumen untuk ' . $dokumen->user->name);
    }
}
