<?php

namespace App\Filament\Pages;

use App\Models\Otp;
use Filament\Pages\Page;

class OtpManager extends Page
{
    protected static string $view = 'filament.pages.otp-manager';

    public ?Otp $currentOtp = null;
    public string $tipe = 'masuk'; // default ke 'masuk'

    public function mount(): void
    {
        $this->currentOtp = Otp::where('admin_id', auth()->id())
            ->where('end_time', '>=', now())
            ->latest()
            ->first();
    }

    public function generateOtp(): void
    {
        Otp::where('admin_id', auth()->id())->delete();

        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $this->currentOtp = Otp::create([
            'admin_id' => auth()->id(),
            'otp' => $otp,
            'tipe' => $this->tipe,
            'start_time' => now(),
            'end_time' => now()->addMinutes(15),
        ]);
           activity()
        ->causedBy(auth()->user())
        ->performedOn($this->currentOtp)
        ->event('generated')
        ->log( auth()->user()->name . ' menghasilkan OTP tipe ' . $this->tipe);
    }
        public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
}
