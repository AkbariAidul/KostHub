<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Filament\Enums\ThemeMode; // Import baru untuk mengatur Light/Dark mode
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\FontProviders\GoogleFontProvider;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            
            // --- 1. SETTING TAMPILAN MODERN & PERFORMANCE ---
            ->spa() // Navigasi instan tanpa reload (terasa lebih cepat/modern)
            ->unsavedChangesAlerts() // Mencegah data hilang jika lupa save
            
            // --- 2. SETTING KONTRAST & TEMA ---
            // Memaksa Light Mode agar Logo Navy 'KOTS' terbaca jelas di background putih
            ->defaultThemeMode(ThemeMode::Light) 
            
            // --- 3. BRANDING ---
            ->brandName('KotsHub')
            ->brandLogo(asset('assets/logos/logopng.png'))
            ->brandLogoHeight('3rem') // Sedikit diperbesar agar lebih gagah
            ->favicon(asset('assets/logos/logopng.png'))
            
            // --- 4. WARNA & FONT ---
            ->colors([
                'primary' => Color::hex('#4FA8C0'), // Warna Tosca Logo
                'gray' => Color::Slate, // Warna Slate memberikan nuansa 'Cool/Dingin' yang modern
            ])
            ->font('Poppins', provider: GoogleFontProvider::class)
            
            // --- 5. LAYOUT ---
            ->sidebarCollapsibleOnDesktop()
            ->maxContentWidth('full')
            ->viteTheme('resources/css/filament/admin/theme.css')
            
            // --- DISCOVERY (DEFAULT) ---
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                // Widget default dimatikan agar Dashboard fokus ke StatsOverview buatanmu
                // Widgets\AccountWidget::class, 
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
            ]);
    }
}