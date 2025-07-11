<?php

namespace App\Providers\Filament;

use Awcodes\Curator\CuratorPlugin;
use Hasnayeen\Themes\ThemesPlugin;
use Hasnayeen\Themes\Http\Middleware\SetTheme;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\UserMenuItem;
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
use Illuminate\Support\Facades\View;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->userMenuItems([
                // Locale sekarang (hanya label)
                UserMenuItem::make()
                    ->label('🌐: ' . strtoupper(app()->getLocale()))
                    ->icon('heroicon-o-language')
                    ->url('#'),

                // // Link ke ID (hanya kalau bukan ID)
                // UserMenuItem::make()
                //     ->label('🇮🇩 ID')
                //     ->url('/locale/id')
                //     ->visible(fn() => app()->getLocale() !== 'id')
                //     ->icon('heroicon-o-arrow-path'),

                // // Link ke EN (hanya kalau bukan EN)
                // UserMenuItem::make()
                //     ->label('en EN')
                //     ->url('/locale/en')
                //     ->visible(fn() => app()->getLocale() !== 'en')
                //     ->icon('heroicon-o-arrow-path'),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->navigationGroups([
                'Catalog',
                'Menu',
                'Media',
                'Transaksi',
                'Settings'
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
                \App\Filament\Widgets\Dashboard::class,
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
                SetTheme::class,
            ])
            ->authGuard('web')
            ->authMiddleware([
                Authenticate::class,
            ])
            ->plugins([
                ThemesPlugin::make(),
                CuratorPlugin::make()
                    ->label('Media Library')
                    ->pluralLabel('Media Library')
                    ->navigationIcon('heroicon-o-photo')
                    ->navigationGroup('Menu')
                    ->navigationSort(6),
            ]);
    }

    public function boot(): void
    {
        View::composer('filament::layouts.app.topbar.end', function ($view) {
            $view->with('localeSwitcher', view('components.locale-switcher'));
        });
    }
}
