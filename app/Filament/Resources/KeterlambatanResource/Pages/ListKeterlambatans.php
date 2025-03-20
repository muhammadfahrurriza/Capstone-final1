<?php

namespace App\Filament\Resources\KeterlambatanResource\Pages;

use App\Filament\Resources\KeterlambatanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListKeterlambatans extends ListRecords
{
    protected static string $resource = KeterlambatanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->hidden(fn () => !Auth::user()->hasRole('Petugas')),
        ];
    }
}
