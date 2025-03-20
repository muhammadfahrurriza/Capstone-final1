<?php

namespace App\Filament\Resources\PenjadwalanResource\Pages;

use App\Filament\Resources\PenjadwalanResource;
use Filament\Actions;
use App\Models\Kehadiran;
use Filament\Resources\Pages\EditRecord;

class EditPenjadwalan extends EditRecord
{
    protected static string $resource = PenjadwalanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        // Runs after the form fields are saved to the database.
        Kehadiran::updateOrCreate(
            ['id' => $this->record->id],[
            'user_id'=> $this->record->user_id,
            'penjadwalan_id'=> $this->record->id,
        ],
        [
            'updated_at' => now(), // Update timestamp or other fields if needed
        ]);
    }
}
