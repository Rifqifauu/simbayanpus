<?php
namespace App\Filament\Widgets;

use Carbon\Carbon;
use App\Models\UserDetail;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PermohonanOverview extends BaseWidget
{
    protected function getStats(): array
    {
        // Menghitung jumlah permohonan masuk dengan status 'pending'
        $pendingCount = UserDetail::whereHas('user', function ($query) {
            $query->whereHas('userDetail', function ($query) {
                $query->where('status_pendaftaran', 'pending');
            });
        })->count();

        // Menghitung jumlah permohonan dengan status 'diproses'
        $processCount = UserDetail::whereHas('user', function ($query) {
            $query->whereHas('userDetail', function ($query) {
                $query->where('status_pendaftaran', 'diproses');
            });
        })->count();

        // Menghitung jumlah permohonan dengan status 'diterima'
        $acceptedCount = UserDetail::whereHas('user', function ($query) {
            $query->whereHas('userDetail', function ($query) {
                $query->where('status_pendaftaran', 'diterima');
            });
        })->count();

        // Menghitung jumlah permohonan yang aktif
        $activeCount = UserDetail::whereHas('user', function ($query) {
            $query->whereHas('userDetail', function ($query) {
                $query->where('status_pendaftaran', 'diterima');
            })
            ->whereHas('Permohonan', function ($query) {
                $query->whereDate('tgl_masuk', '<=', Carbon::today())  // Ensure tgl_masuk is before or today
                    ->whereDate('tgl_keluar', '>=', Carbon::today()); // Ensure tgl_keluar is after or today
            });
        })->count();

        return [
            Stat::make('Permohonan Masuk', $pendingCount)
                ->icon('heroicon-o-inbox')
                ->label('Permohonan yang masuk dan belum diproses'),

            Stat::make('Permohonan Diproses', $processCount)
                ->icon('heroicon-o-cog')
                ->label('Permohonan yang sedang diproses'),

            Stat::make('Permohonan Diterima', $acceptedCount)
                ->icon('heroicon-o-check-circle')
                ->label('Permohonan yang sudah diterima'),

            Stat::make('Magang Aktif', $activeCount)
                ->icon('heroicon-o-fire')
                ->label('Magang yang sedang aktif'),
        ];
    }
}
