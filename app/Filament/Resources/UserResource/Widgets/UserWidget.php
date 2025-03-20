<?php

namespace App\Filament\Resources\UserResource\Widgets;

use App\Models\User;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UserWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $totalPemohonKegiatan = User::whereHas('roles', function ($query) {
            $query->where('name', 'Pemohon Kegiatan');
        })->count();

        $totalPesertaKegiatan = User::whereHas('roles', function ($query) {
            $query->where('name', 'Peserta Kegiatan');
        })->count();

        return [
            Stat::make('Pengguna', User::count())
                ->description("Jumlah pengguna")
                ->descriptionIcon('heroicon-o-user-group', IconPosition::Before)
                ->chart([1, 3, 5, 10, 20, 40]),
            Stat::make('Pemohon Kegiatan', $totalPemohonKegiatan)
                ->description("Jumlah Pemohon Kegiatan")
                ->descriptionIcon('heroicon-o-user-group')
                ->chart([3, 6, 9, 12, 15]),
            // ->color('primary'),
            Stat::make('Peserta Kegiatan', $totalPesertaKegiatan)
                ->description("Jumlah Peserta Kegiatan")
                ->descriptionIcon('heroicon-o-user-group')
                ->chart([4, 8, 12, 16, 20]),
            // ->color('warning'),
        ];
    }
}
