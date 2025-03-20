<?php

namespace App\Filament\Resources\BBMResource\Pages;

use App\Filament\Resources\BBMResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBBM extends EditRecord
{
    protected static string $resource = BBMResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }
}
