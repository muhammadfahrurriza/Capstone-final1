<?php

namespace App\Filament\Resources\BookRequestResource\Pages;

use App\Filament\Resources\BookRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListBookRequests extends ListRecords
{
    protected static string $resource = BookRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->hidden(fn () => !Auth::user()->hasAnyRole(['Pemohon Kegiatan', 'Peserta Kegiatan'])),
        ];
    }
}
