<?php

namespace App\Filament\Kadin\Pages;

use Filament\Pages\Page;

class Chat extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.chat';

    public function getTitle(): string
    {
        return '';
    }
}
