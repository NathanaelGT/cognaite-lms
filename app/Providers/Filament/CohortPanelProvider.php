<?php

namespace App\Providers\Filament;

use App\Enums\Role;
use App\Filament\Cohort\Pages\Login;
use App\Filament\Socialite\Provider;
use App\Models\User;
use DutchCodingCompany\FilamentSocialite\FilamentSocialitePlugin;
use Filament\Enums\ThemeMode;
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
use Laravel\Socialite\Contracts\User as SocialiteUserContract;

class CohortPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('cohort')
            ->path('')
            ->spa()
            ->login(Login::class)
            ->colors([
                'primary' => Color::Amber,
            ])
            ->defaultThemeMode(ThemeMode::Light)
            ->favicon(asset('img/logo.svg'))
            ->brandName('Cognaite LMS')
            ->discoverResources(in: app_path('Filament/Cohort/Resources'), for: 'App\\Filament\\Cohort\\Resources')
            ->discoverPages(in: app_path('Filament/Cohort/Pages'), for: 'App\\Filament\\Cohort\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Cohort/Widgets'), for: 'App\\Filament\\Cohort\\Widgets')
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
            ->plugins([
                FilamentSocialitePlugin::make()
                    ->providers([
                        Provider::make('google')
                            ->icon('google')
                            ->resolveLabelUsing(fn() => __('Login with Google')),
                    ])
                    ->registration()
                    ->showDivider(false)
                    ->createUserUsing(static function (string $provider, SocialiteUserContract $oauthUser) {
                        $user = new User([
                            'name' => $oauthUser->getName(),
                            'email' => $oauthUser->getEmail(),
                            'avatar_url' => $oauthUser->getAvatar(),
                        ])->forceFill([
                            'role' => Role::Cohort,
                            'email_verified_at' => now(),
                        ]);

                        $user->save();

                        return $user;
                    }),
            ]);
    }
}
