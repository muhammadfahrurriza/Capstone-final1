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
use Althinect\FilamentSpatieRolesPermissions\FilamentSpatieRolesPermissionsPlugin;
use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\NavigationGroup;
use App\Filament\Resources\SuratResource;
use App\Filament\Resources\PengajuanResource;
use App\Filament\Resources\JamKerjaResource;
use App\Filament\Resources\LokasiResource;
use App\Filament\Resources\PenjadwalanResource;
use App\Filament\Resources\KehadiranResource;
use App\Filament\Resources\BookRequestResource;
use App\Filament\Resources\BookResource;
use App\Filament\Resources\BorrowResource;
use App\Filament\Resources\KategoriBukuResource;
use App\Filament\Resources\MobilResource;
use App\Filament\Resources\PenilaianPegawaiResource;
use App\Filament\Resources\PopularitasResource;
use App\Filament\Resources\UserResource;
use App\Filament\Resources\ReimburseResource;
use App\Filament\Resources\KeterlambatanResource;
use Filament\Navigation\NavigationItem;
use Filament\Pages\Dashboard;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\Blade;
use Awcodes\WireChat\WireChatPlugin;
use Joaopaulolndev\FilamentEditProfile\FilamentEditProfilePlugin;
use Filament\Navigation\MenuItem;
use Joaopaulolndev\FilamentEditProfile\Pages\EditProfilePage;
use function request;
use Saade\FilamentFullCalendar\FilamentFullCalendarPlugin;



class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->maxContentWidth('full')
            ->sidebarWidth('auto')
            ->sidebarCollapsibleOnDesktop(true)
            ->brandLogo(asset('storage/img/logo_smg.png'))
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
            ])
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->renderHook(
                PanelsRenderHook::HEAD_END,
                fn(): string => Blade::render('@wirechatStyles'),
            )
            ->renderHook(
                PanelsRenderHook::BODY_END,
                fn(): string => Blade::render('@wirechatAssets'),
            )
            // ->spa()
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
                FilamentSpatieRolesPermissionsPlugin::make(),
                // \EightyNine\Approvals\ApprovalPlugin::make(),
                FilamentEditProfilePlugin::make()
                    ->setIcon('heroicon-o-user')
                    ->shouldShowAvatarForm(
                        value: true,
                        directory: 'avatars'
                    ),
                FilamentFullCalendarPlugin::make()
                    ->schedulerLicenseKey('')
                    // ->selectable(true)
                    // ->editable()
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
                                ->isActiveWhen(fn(): bool => request()->routeIs('filament.admin.pages.dashboard'))
                                ->url(fn(): string => Dashboard::getUrl()),
                            NavigationItem::make('Chat')
                                ->icon('heroicon-o-chat-bubble-left')
                                ->url(fn(): string => '/admin/chat'),
                        ]),

                    NavigationGroup::make('Surat')
                        ->items([
                            ...SuratResource::getNavigationItems(),
                            // ...PenjadwalanResource::getNavigationItems(),
                            // ...KehadiranResource::getNavigationItems(),                           
                            // ...PengajuanResource::getNavigationItems(),
                            // ...JamKerjaResource::getNavigationItems(),
                            // ...LokasiResource::getNavigationItems(),
                        ]),
                    NavigationGroup::make('Penjadwalan')
                    ->items([
                        // ...SuratResource::getNavigationItems(),
                        ...PenjadwalanResource::getNavigationItems(),
                        ...KehadiranResource::getNavigationItems(),
                        ...PenilaianPegawaiResource::getNavigationItems(),
                        ...MobilResource::getNavigationItems(),
                        ...KeterlambatanResource::getNavigationItems(),
                        ...ReimburseResource::getNavigationItems(),
                        // ...PengajuanResource::getNavigationItems(),
                        // ...JamKerjaResource::getNavigationItems(),
                        // ...LokasiResource::getNavigationItems(),
                    ]),
                    NavigationGroup::make('Buku')
                    ->items([
                        ...BookResource::getNavigationItems(),    
                        ...BorrowResource::getNavigationItems(),
                        ...KategoriBukuResource::getNavigationItems(),
                        ...BookRequestResource::getNavigationItems(),
                        ...PopularitasResource::getNavigationItems(),
                        
                    ]),
                    NavigationGroup::make('User Management')
                        ->items([
                            ...UserResource::getNavigationItems(),
                            NavigationItem::make('Roles')
                                ->icon('heroicon-o-user-group')
                                ->isActiveWhen(fn(): bool => request()->routeIs([
                                    'filament.admin.resources.roles.index',
                                    'filament.admin.resources.roles.create',
                                    'filament.admin.resources.roles.view',
                                    'filament.admin.resources.roles.edit'
                                ]))
                                ->url(fn(): string => '/admin/roles'),
                            NavigationItem::make('Permisions')
                                ->icon('heroicon-o-lock-closed')
                                ->isActiveWhen(fn(): bool => request()->routeIs([
                                    'filament.admin.resources.permissions.index',
                                    'filament.admin.resources.permissions.create',
                                    'filament.admin.resources.permissions.view',
                                    'filament.admin.resources.permissions.edit'
                                ]))
                                ->url(fn(): string => '/admin/permissions'),
                            NavigationItem::make('Edit Profil')
                                ->icon('heroicon-o-user-circle')

                                ->isActiveWhen(fn(): bool => request()->routeIs('filament.admin.resources.users.edit'))
                                ->url(fn(): string => '/admin/edit-profile'),
                        ]),
                ]);
            })
        ;
    }
}