<?php

namespace App\Filament\Admin\Pages;

use App\Models\Batch;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static string $view = 'filament.admin.pages.dashboard';
    protected static string $routePath = 'dashboard';

    protected ?string $heading = 'Dashboard Saya';
    protected static ?string $navigationLabel = 'Dashboard';

    public $batches;
    public $hasBatches;

    public function mount()
    {
        $user = Auth::user();
        $this->batches = Batch::whereHas('users', fn ($q) => $q->where('user_id', $user->id))
            ->with(['posts', 'users' => fn($q) => $q->where('user_id', $user->id)])
            ->get();

        $this->hasBatches = $this->batches->isNotEmpty();
    }
}
