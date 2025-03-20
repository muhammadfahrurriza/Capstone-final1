<?php

namespace App\Filament\Resources\ReimburseResource\Pages;

use App\Filament\Resources\ReimburseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReimburse extends EditRecord
{
    protected static string $resource = ReimburseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
