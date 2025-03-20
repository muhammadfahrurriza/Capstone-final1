<?php

namespace App\Filament\Resources\KehadiranResource\Pages;

use App\Filament\Resources\KehadiranResource;
use Filament\Resources\Pages\Page;
use App\Models\Penjadwalan;
use App\Models\Surat;
use App\Models\JamKerja;
use App\Models\Lokasi;
use App\Models\Kehadiran;

class LaporanKehadiran extends Page
{
    protected static string $resource = KehadiranResource::class;

    protected static string $view = 'filament.resources.kehadiran-resource.pages.laporan-kehadiran';

    public $record;
    public $surat;
    public $findlokasi;
    public $findjamkerja;

    public function mount($record)
    {
        // $this->surat = Kehadiran::with(['penjadwalan.surat.lokasi', 'penjadwalan.surat.jamkerja'])->find($record);
        
        // $this->jamkerja = $surat->penjadwalan->surat->jamkerja ?? null;
        // $this->lokasi = $surat->penjadwalan->surat->lokasi ?? null;
        $this->record = Kehadiran::with([
            'penjadwalan.surat.lokasi',
            'penjadwalan.surat.jamkerja'
        ])->findOrFail($record);
    
        $this->surat = $this->record->penjadwalan->surat ?? null;
        $this->findlokasi = $this->surat->lokasi ?? null;
        $this->findjamkerja = $this->surat->jamkerja ?? null;
        // $this->record = Kehadiran::findOrFail($record);

    }

    public function getHeaderActions(): array
    {
        return [];
    }
}
