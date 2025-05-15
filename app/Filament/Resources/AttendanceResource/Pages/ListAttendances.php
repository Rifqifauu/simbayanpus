<?php

namespace App\Filament\Resources\AttendanceResource\Pages;

use App\Filament\Resources\AttendanceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\Action;


class ListAttendances extends ListRecords
{
    protected static string $resource = AttendanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
        Actions\CreateAction::make()
 ->modalHeading('Input Presensi Manual')
         ->label('Input Presensi Manual'),
           Action::make('buatOtp')
            ->label('Presensi OTP')
            ->url('/admin/otp-manager')
            ->icon('heroicon-o-lock-closed')
            ->color('primary'),
        ];
    }
}
