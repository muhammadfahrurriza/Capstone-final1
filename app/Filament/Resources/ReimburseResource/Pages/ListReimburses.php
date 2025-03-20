<?php

namespace App\Filament\Resources\ReimburseResource\Pages;

use App\Filament\Resources\ReimburseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListReimburses extends ListRecords
{
    protected static string $resource = ReimburseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->hidden(fn () => !Auth::user()->hasRole('Petugas')),
        ];
    }
}
