<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use App\Filament\Resources\SuratResource;
use App\Models\Surat;

class CelendarWidget extends FullCalendarWidget
{
    public function fetchEvents(array $fetchInfo): array
    {
        return Surat::with('jamkerja')
            ->whereHas('jamkerja', function ($query) use ($fetchInfo) {
                $query->where('jam_mulai', '>=', $fetchInfo['start'])
                    ->where('jam_akhir', '<=', $fetchInfo['end']);
            })
            ->get()
            ->map(
                fn(Surat $surat) => [
                    'id' => $surat->id,
                    'title' => $surat->nama_kegiatan,
                    'start' => $surat->alamat,
                    'start' => $surat->jamkerja->jam_mulai,
                    'end' => $surat->jamkerja->jam_akhir,
                    'url' => SuratResource::getUrl(name: 'view', parameters: ['record' => $surat]),
                    'shouldOpenUrlInNewTab' => true
                ]
            )
            ->all();
    }
}
