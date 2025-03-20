<?php

namespace App\Filament\Pemohon\Pages;

use Filament\Pages\Page;

class Chat extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pemohon.pages.chat';

    public function getTitle(): string
    {
        return '';
    }
}
