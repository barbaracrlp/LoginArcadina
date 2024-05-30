<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\LoginEdit;
use App\Filament\Widgets\AccountWidget;
use Filament\Http\Middleware\Authenticate;
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
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

use App\Filament\Widgets\UltimasGalerias;

class GeneralPanelProvider extends PanelProvider
{
   

    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->darkMode(false)
            ->id('gestion')
            ->path('gestion')
            ->brandLogo(asset('images/vectorialLargo.png'))
            ->favicon(asset('images/vectorialCirculo.jpg'))
            ->login(LoginEdit::class)
            ->colors([
           
                'primary' => "#21ABE3",  
                'danger' => "#EF4444",
                'info' => "#21ABE3",
                'success' => "#10B981",
                'warning' => "#f97316",
                'sin'=>Color::Zinc,
                'pendiente'=>Color::Purple,
                'enviado'=>Color::Green,
                'neutral'=>"#6B7280",


            ])
            ->brandName("Arcadina")
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                // Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                AccountWidget::class,
                UltimasGalerias::class,
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
