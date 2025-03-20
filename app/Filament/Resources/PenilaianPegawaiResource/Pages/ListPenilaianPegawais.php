<?php

namespace App\Filament\Resources\PenilaianPegawaiResource\Pages;

use App\Filament\Resources\PenilaianPegawaiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListPenilaianPegawais extends ListRecords
{
    protected static string $resource = PenilaianPegawaiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->hidden(fn () => !Auth::user()->hasAnyRole(['Pemohon Kegiatan', 'Peserta Kegiatan'])),
        ];
    }
}
