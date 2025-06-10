<?php

namespace App\Filament\Cohort\Pages;

use App\Models\Batch;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static string $view = 'filament.cohort.pages.dashboard';
    protected static string $routePath = 'dashboard';

    protected ?string $heading = 'Dashboard Saya';
    protected static ?string $navigationLabel = 'Dashboard';

    public $ongoingBatches;
    public $completedBatches;
    public $hasOngoingBatches;
    public $hasCompletedBatches;

    public function mount()
    {
        $user = Auth::user();

        // Batch yang masih dikerjakan (progress < 100%)
        $this->ongoingBatches = Batch::whereHas('users', fn ($q) => $q->where('user_id', $user->id))
            ->with(['posts', 'users' => fn($q) => $q->where('user_id', $user->id)])
            ->get()
            ->filter(fn($batch) => $batch->progress_percentage < 100)
            ->sortByDesc('progress_percentage')
            ->take(10); // Limit 10

        // Batch yang sudah selesai (progress 100%)
        $this->completedBatches = Batch::whereHas('users', fn ($q) => $q->where('user_id', $user->id))
            ->with(['posts', 'users' => fn($q) => $q->where('user_id', $user->id)])
            ->get()
            ->filter(fn($batch) => $batch->progress_percentage == 100)
            ->sortByDesc('updated_at')
            ->take(6); // Limit 6

        $this->hasOngoingBatches = $this->ongoingBatches->isNotEmpty();
        $this->hasCompletedBatches = $this->completedBatches->isNotEmpty();
    }
}
