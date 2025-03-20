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
use Saade\FilamentFullCalendar\FilamentFullCalendarPlugin;
use Joaopaulolndev\FilamentEditProfile\FilamentEditProfilePlugin;
use Filament\Navigation\MenuItem;
use Joaopaulolndev\FilamentEditProfile\Pages\EditProfilePage;
use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;

use App\Filament\Resources\ReimburseResource;
use App\Filament\Resources\KehadiranResource;
use App\Filament\Resources\SuratResource;
use App\Filament\Resources\KeterlambatanResource;
use App\Filament\Resources\BookRequestResource;
use App\Filament\Resources\BookResource;
use App\Filament\Resources\BorrowResource;
use App\Filament\Resources\KategoriBukuResource;
use App\Filament\Resources\PopularitasResource;


class PetugasPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->maxContentWidth('full')
            ->sidebarWidth('auto')
            ->sidebarCollapsibleOnDesktop(true)
            ->brandLogo(asset('storage/img/logo_smg.png'))
            ->id('petugas')
            ->path('petugas')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->resources([
                SuratResource::class,
                KehadiranResource::class,
                ReimburseResource::class,
                KeterlambatanResource::class,
                BookRequestResource::class,
                BookResource::class,
                BorrowResource::class,
                KategoriBukuResource::class,
                PopularitasResource::class,
            ])
            ->discoverResources(in: app_path('Filament/Petugas/Resources'), for: 'App\\Filament\\Petugas\\Resources')
            ->discoverPages(in: app_path('Filament/Petugas/Pages'), for: 'App\\Filament\\Petugas\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                // Widgets\FilamentInfoWidget::class,
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
            ->plugins([                
                FilamentEditProfilePlugin::make()
                    ->setIcon('heroicon-o-user')
                    ->shouldShowAvatarForm(
                        value: true,
                        directory: 'avatars'
                    ),
                FilamentFullCalendarPlugin::make()
                    ->schedulerLicenseKey('')
                    ->selectable(false)
                    ->editable(false)
                    ->timezone(config('app.timezone'))
                    ->locale(config('app.locale'))
                    ->plugins(['dayGrid', 'timeGrid'])
                    ->config([])
            ])
            ->userMenuItems([
                MenuItem::make()
                    ->label('Edit profile')
                    ->url(fn(): string => EditProfilePage::getUrl())
                    ->icon('heroicon-m-user-circle'),
            ])
            ->navigation(function (NavigationBuilder $builder): NavigationBuilder {
                return $builder->groups([
                    NavigationGroup::make('Dashboard')
                        ->items([
                            NavigationItem::make('Dashboard')
                                ->icon('heroicon-o-home')
                                ->isActiveWhen(fn(): bool => request()->routeIs('filament.petugas.pages.dashboard'))
                                ->url(fn(): string => '/petugas'),
                            NavigationItem::make('Chat')
                                ->icon('heroicon-o-chat-bubble-left')
                                ->url(fn(): string => '/petugas/chat'),
                        ]),
                    NavigationGroup::make('Penjadwalan')
                    ->items([
                        ...KehadiranResource::getNavigationItems(),
                        ...KeterlambatanResource::getNavigationItems(),
                        ...ReimburseResource::getNavigationItems(),
                    ]),
                    NavigationGroup::make('User Management')
                        ->items([
                            NavigationItem::make('Edit Profil')
                                ->icon('heroicon-o-user-circle')
                                ->isActiveWhen(fn(): bool => request()->routeIs('filament.petugas.resources.users.edit'))
                                ->url(fn(): string => '/petugas/edit-profile'),
                        ]),
                    ]);
                });
    }
}
