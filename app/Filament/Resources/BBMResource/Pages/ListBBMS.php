<?php

namespace App\Filament\Resources\BBMResource\Pages;

use App\Filament\Resources\BBMResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBBMS extends ListRecords
{
    protected static string $resource = BBMResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
