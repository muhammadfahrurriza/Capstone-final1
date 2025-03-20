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
use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Pages\Dashboard;

use App\Filament\Resources\SuratResource;
use App\Filament\Resources\KehadiranResource;
use App\Filament\Resources\PenilaianPegawaiResource;
use App\Filament\Resources\KeterlambatanResource;
use App\Filament\Resources\BookRequestResource;
use App\Filament\Resources\PopularitasResource;


class KadinPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('kadin')
            ->path('kadin')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->resources([
                SuratResource::class,
                KehadiranResource::class,
                PenilaianPegawaiResource::class,
                KeterlambatanResource::class,
                BookRequestResource::class,
                PopularitasResource::class,
            ])
            // ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            // ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            // ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
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
            ])
            // ->navigation(function (NavigationBuilder $builder): NavigationBuilder {
            //     return $builder->groups([
            //         NavigationGroup::make('Dashboard')
            //             ->items([
            //                 NavigationItem::make('Dashboard')
            //                     ->icon('heroicon-o-home')
            //                     ->isActiveWhen(fn(): bool => request()->routeIs('filament.admin.pages.dashboard'))
            //                     ->url(fn(): string => Dashboard::getUrl()),
            //             ]),
            //         // NavigationGroup::make('Reimburse')
            //         // ->items([
            //         //     ...ReimburseResource::getNavigationItems(),
            //         // ]),
            //     ]);
            // })
            ;
    }
}
