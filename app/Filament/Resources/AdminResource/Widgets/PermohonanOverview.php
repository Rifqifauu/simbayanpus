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
        // Jumlah permohonan masuk dengan status 'pending'
        $pendingCount = UserDetail::whereHas('user', function ($query) {
            $query->whereHas('userDetail', function ($query) {
                $query->where('status_pendaftaran', 'pending');
            });
        })->count();

        // Jumlah permohonan dengan status 'diproses'
        $processCount = UserDetail::whereHas('user', function ($query) {
            $query->whereHas('userDetail', function ($query) {
                $query->where('status_pendaftaran', 'diproses');
            });
        })->count();

        // Jumlah permohonan dengan status 'diterima'
        $acceptedCount = UserDetail::whereHas('user', function ($query) {
            $query->whereHas('userDetail', function ($query) {
                $query->where('status_pendaftaran', 'diterima');
            });
        })->count();

        // Jumlah magang aktif (hari ini berada di antara tgl_masuk dan tgl_keluar)
        $activeCount = UserDetail::whereHas('user', function ($query) {
            $query->whereHas('userDetail', function ($query) {
                $query->where('status_pendaftaran', 'diterima');
            })->whereHas('Permohonan', function ($query) {
                $query->whereDate('tgl_masuk', '<=', Carbon::today())
                      ->whereDate('tgl_keluar', '>=', Carbon::today());
            });
        })->count();

        // Jumlah magang selesai (tgl_keluar < hari ini dan status 'diterima')
        $finishedCount = UserDetail::whereHas('user', function ($query) {
            $query->whereHas('userDetail', function ($query) {
                $query->where('status_pendaftaran', 'diterima');
            })->whereHas('Permohonan', function ($query) {
                $query->whereDate('tgl_keluar', '<', Carbon::today());
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

            Stat::make('Magang Selesai', $finishedCount)
                ->icon('heroicon-o-check')
                ->label('Magang yang telah selesai dan menunggu finalisasi')
        ];
    }
}
