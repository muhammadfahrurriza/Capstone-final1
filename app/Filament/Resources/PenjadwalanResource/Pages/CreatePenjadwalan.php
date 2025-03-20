<?php

namespace App\Filament\Resources\PenjadwalanResource\Pages;

use App\Filament\Resources\PenjadwalanResource;
use Filament\Actions;
use App\Models\Kehadiran;
use Filament\Resources\Pages\CreateRecord;

class CreatePenjadwalan extends CreateRecord
{
    protected static string $resource = PenjadwalanResource::class;

    protected function afterCreate(): void
    {
        // Runs after the form fields are saved to the database.
        Kehadiran::create([
            'user_id'=> $this->record->user_id,
            'penjadwalan_id'=> $this->record->id,
        ]);
    }
}
