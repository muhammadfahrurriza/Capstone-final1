<?php

namespace App\Filament\Resources\SuratResource\Pages;

use App\Filament\Resources\SuratResource;
use Filament\Actions;
use App\Models\Pengajuan;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateSurat extends CreateRecord
{
    protected static string $resource = SuratResource::class;

    public static function canAccess(array $parameters = []): bool
    {
        return  Auth::user()->hasRole('Pemohon Kegiatan');
    }

    protected function afterCreate(): void
    {
        // Runs after the form fields are saved to the database.
        $pengajuan = Pengajuan::create([
            'tgl_pengajuan'=> $this->record->created_at,
        ]);
        $this->record->update([
            'pengajuan_id' => $pengajuan->id,
        ]);
    }
}
