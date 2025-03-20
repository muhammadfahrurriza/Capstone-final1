<?php

namespace App\Filament\Peserta\Pages;

use Filament\Pages\Page;

class Chat extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.peserta.pages.chat';

    public function getTitle(): string
    {
        return '';
    }
}
