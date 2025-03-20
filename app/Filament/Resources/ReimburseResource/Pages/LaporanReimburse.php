<?php

namespace App\Filament\Resources\ReimburseResource\Pages;

use App\Filament\Resources\ReimburseResource;
use Filament\Resources\Pages\Page;
use App\Models\Reimburse;

class LaporanReimburse extends Page
{
    protected static string $resource = ReimburseResource::class;

    protected static string $view = 'filament.resources.reimburse-resource.pages.laporan-reimburse';

    public $record;
    public $reimburse;

    public function mount($record)
    {
        $this->reimburse = Reimburse::with(['bbm', 'souvenir'])->find($record);
        $this->record = Reimburse::findOrFail($record);
    }

    public function getHeaderActions(): array
    {
        return [];
    }
}
