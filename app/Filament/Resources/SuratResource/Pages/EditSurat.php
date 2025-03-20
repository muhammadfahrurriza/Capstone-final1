<?php

namespace App\Filament\Resources\SuratResource\Pages;

use App\Filament\Resources\SuratResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditSurat extends EditRecord
{
    protected static string $resource = SuratResource::class;

    public static function canAccess(array $parameters = []): bool
    {
        return  Auth::user()->hasRole('Pemohon Kegiatan');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
