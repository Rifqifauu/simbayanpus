<?php

namespace App\Filament\Resources\DokumenResource\Pages;

use App\Filament\Resources\DokumenResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Pages\Actions\Action;
use App\Filament\Resources\DokumenResource\Pages\ListDokumens; 

class EditDokumen extends EditRecord
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
    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Kembali')
                ->icon('heroicon-o-arrow-left')
                ->color('gray')
                ->url(ListDokumens::getUrl()),        ];
    }
}
