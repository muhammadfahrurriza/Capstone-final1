<?php

namespace App\Filament\Resources\KehadiranResource\Pages;

use App\Filament\Resources\KehadiranResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Livewire\TemporaryUploadedFile;
use Illuminate\Support\Facades\Storage;

class EditKehadiran extends EditRecord
{
    protected static string $resource = KehadiranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }
}
