<?php

namespace App\Providers\Filament;

use Caresome\FilamentNeobrutalism\NeobrutalismeTheme;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('park')
            ->spa()
            ->sidebarWidth('16rem')
            ->topNavigation()
            ->breadcrumbs(false)
            ->brandLogo(fn() => view('logo.icon'))
            ->brandLogoHeight('3rem')
            ->favicon(asset('images/iconpark.png'))
            ->databaseNotifications()
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
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
                NeobrutalismeTheme::make()
                    ->customize([
                        'border-width'       => '3px',
                        'border-width-thick' => '4px',

                        'radius-sm' => '0.25rem',
                        'radius-md' => '0.5rem',
                        'radius-lg' => '0.75rem',
                        'radius-xl' => '1rem',

                        'shadow-offset-sm' => '3px',
                        'shadow-offset-md' => '5px',
                        'shadow-offset-lg' => '7px',
                        'shadow-offset-xl' => '9px',

                        'font-weight-bold'      => '700',
                        'font-weight-extrabold' => '800',
                        'font-weight-black'     => '900',
                        'letter-spacing-normal' => '-0.02em',
                        'letter-spacing-wide'   => '0.04em',

                        'transition-duration' => '200ms',

                        'spacing-md' => '0.875rem',
                        'spacing-lg' => '1.25rem',
                        'spacing-xl' => '1.75rem',
                    ]),
            ]);
    }
}
