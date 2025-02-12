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
use Illuminate\Support\Facades\Gate; // Importar la clase Gate

class SeguridadPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {

        // Verificar si el usuario tiene el rol de super_admin
        Gate::define('access-seguridad-panel', function ($user) {
            return $user->hasRole('super_admin');
        });

        return $panel
            ->id('seguridad')
            ->path('seguridad')
            ->login()
            ->colors([
                'primary' => Color::Red,
            ])
            ->discoverResources(in: app_path('Filament/Seguridad/Resources'), for: 'App\\Filament\\Seguridad\\Resources')
            ->discoverPages(in: app_path('Filament/Seguridad/Pages'), for: 'App\\Filament\\Seguridad\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Seguridad/Widgets'), for: 'App\\Filament\\Seguridad\\Widgets')
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
                \App\Http\Middleware\CheckAdminRole::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->plugin(\FilipFonal\FilamentLogManager\FilamentLogManager::make())
            ->plugin(\TomatoPHP\FilamentLogger\FilamentLoggerPlugin::make());
    }
}
