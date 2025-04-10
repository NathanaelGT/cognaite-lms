<?php

namespace App\Filament\Cohort\Pages;

use App\Models\Batch;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;

class BatchSaya extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static string $view = 'filament.cohort.pages.batch-saya';

    public $batches = [];
    public $expandedBatchId = null;

    public function mount()
    {
        $this->batches = Auth::user()?->batches()->with('courses')->get() ?? [];
    }

    public function dropBatch($batchId)
    {
        $user = Auth::user();

        if ($user->batches()->where('batch_id', $batchId)->exists()) {
            $user->batches()->detach($batchId);

            $this->batches = $user->batches()->with('courses')->get();

            Notification::make()
                ->title('Kamu telah keluar dari batch ini.')
                ->success()
                ->send();
        }
    }

    public function toggleDetail($batchId)
    {
        $this->expandedBatchId = $this->expandedBatchId === $batchId ? null : $batchId;
    }
}
