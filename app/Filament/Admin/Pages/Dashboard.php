<?php

namespace App\Filament\Admin\Pages;

use App\Models\Batch;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Filament\Pages\Page;
use Livewire\Attributes\On;

class Dashboard extends Page
{
    protected static string $view = 'filament.admin.pages.dashboard';

    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Dashboard';
    protected static ?string $title = 'Dashboard';

    public ?string $start_date = null;
    public ?string $end_date = null;

    public int $userCount = 0;
    public int $batchCount = 0;
    public int $completedBatchCount = 0;
    public array $popularBatches = [];
    public array $salesChartData = [];
    public array $latestTransactions = [];

    public function mount(): void
    {
        $this->loadData();
    }

    #[On('apply-filters')]
    public function applyFilters(): void
    {
        $this->loadData();
    }

    protected function loadData(): void
    {
        $startDate = $this->start_date ? Carbon::parse($this->start_date)->startOfDay() : Carbon::now()->subDays(6)->startOfDay();
        $endDate = $this->end_date ? Carbon::parse($this->end_date)->endOfDay() : Carbon::now()->endOfDay();

        if ($startDate->gt($endDate)) {
            $endDate = $startDate;
            $this->end_date = $startDate->format('Y-m-d');
        }

        $this->userCount = User::count();
        $this->batchCount = Batch::count();
        $this->completedBatchCount = User::whereHas('batches')->get()->filter(fn($u) =>
            $u->batches->filter(fn($b) => $u->isCompletedBatch($b->id))->count() > 0
        )->count();

        $period = CarbonPeriod::create($startDate, $endDate);
        $dates = collect($period)->map(fn($date) => $date->format('Y-m-d'))->toArray();
        $rawData = Transaction::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as date, SUM(price) as total')
            ->groupBy('date')
            ->pluck('total', 'date')
            ->toArray();

        $this->salesChartData = collect($dates)->map(fn($date) => [
            'x' => $date,
            'y' => (float) ($rawData[$date] ?? 0),
        ])->values()->toArray();

        $this->popularBatches = Batch::withCount(['users' => fn($q) =>
        $q->whereBetween('batch_user.created_at', [$startDate, $endDate])
        ])
            ->orderByDesc('users_count')
            ->limit(5)
            ->get()
            ->map(fn($b) => [
                'name' => $b->name,
                'users_count' => $b->users_count,
            ])->toArray();

        $this->latestTransactions = Transaction::whereBetween('created_at', [$startDate, $endDate])
            ->latest()->with(['user', 'batch'])->limit(5)->get()->toArray();
    }
}
