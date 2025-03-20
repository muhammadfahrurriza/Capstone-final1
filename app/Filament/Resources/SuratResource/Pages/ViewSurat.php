<?php

namespace App\Filament\Resources\SuratResource\Pages;

use App\Filament\Resources\SuratResource;
use App\Models\Surat;
use Filament\Resources\Pages\Page;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Auth;


class ViewSurat extends Page
{
    protected static string $resource = SuratResource::class;

    public $record;
    public $surat;

    // public static function canAccess(array $parameters = []): bool
    // {
    //     return  Auth::user()->hasRole('Petugas');
    // }
    public function mount($record)
    {
        $this->surat = Surat::with(['jamkerja', 'lokasi'])->find($record);
        $this->record = Surat::findOrFail($record);
    }

    public function getHeaderActions(): array
    {
        return [];
    }
    

    protected static string $view = 'filament.resources.surat-resource.pages.view-surat';
}
