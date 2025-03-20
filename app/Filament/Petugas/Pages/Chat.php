<?php

namespace App\Filament\Petugas\Pages;

use Filament\Pages\Page;

class Chat extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.petugas.pages.chat';

    public function getTitle(): string
    {
        return '';
    }
}
