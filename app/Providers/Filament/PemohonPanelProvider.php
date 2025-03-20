<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

use App\Filament\Resources\SuratResource;
use App\Filament\Resources\PenilaianPegawaiResource;
use App\Filament\Resources\BookRequestResource;

class PemohonPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->maxContentWidth('full')
            ->sidebarWidth('auto')
            ->sidebarCollapsibleOnDesktop(true)
            ->brandLogo(asset('storage/img/logo_smg.png'))
            ->id('pemohon')
            ->path('pemohon')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->resources([
                SuratResource::class,
                PenilaianPegawaiResource::class,
                BookRequestResource::class,
            ])
            ->discoverResources(in: app_path('Filament/Pemohon/Resources'), for: 'App\\Filament\\Pemohon\\Resources')
            ->discoverPages(in: app_path('Filament/Pemohon/Pages'), for: 'App\\Filament\\Pemohon\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Pemohon/Widgets'), for: 'App\\Filament\\Pemohon\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
