<?php

namespace App\Filament\Cohort\Pages;

use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Filament\Facades\Filament;
use Filament\Pages\SimplePage;

class Login extends SimplePage
{
    use WithRateLimiting;

    protected static string $view = 'filament.cohort.pages.login';

    protected ?string $heading = 'Cognaite Academy LMS';

    protected ?string $maxWidth = 'max-w-sm';

    public function mount(): void
    {
        if (Filament::auth()->check()) {
            redirect()->intended(Filament::getUrl());
        }
    }
}
