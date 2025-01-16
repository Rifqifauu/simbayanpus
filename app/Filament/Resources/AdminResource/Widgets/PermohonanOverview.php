<?php
namespace App\Filament\Widgets;

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

        return [
            Stat::make('Permohonan masuk', $pendingCount),
            Stat::make('Permohonan diproses', $processCount),
            Stat::make('Permohonan diterima', $acceptedCount),
        ];
    }
}
