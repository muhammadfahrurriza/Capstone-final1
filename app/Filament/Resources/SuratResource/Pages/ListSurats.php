<?php

namespace App\Filament\Resources\SuratResource\Pages;

use App\Filament\Resources\SuratResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListSurats extends ListRecords
{
    protected static string $resource = SuratResource::class;

    public static function canAccess(array $parameters = []): bool
    {
        return  Auth::user()->hasAnyRole(['Admin', 'Sekretaris Dinas', 'Kepala Dinas', 'Pemohon Kegiatan']);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->hidden(fn () => !Auth::user()->hasRole('Pemohon Kegiatan')),
        ];
    }
}
