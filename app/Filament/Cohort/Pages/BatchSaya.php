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

    public $batches;
    public $detailBatchId = null;

    public function mount()
    {
        $this->batches = Auth::user()->batches()->with('posts')->get();
    }

    public function dropBatch($batchId)
    {
        Auth::user()->batches()->detach($batchId);
        $this->batches = Auth::user()->batches()->with('posts')->get();

        Notification::make()
            ->title('Kamu telah keluar dari batch.')
            ->success()
            ->send();
    }

    public function showDetail($batchId)
    {
        $this->detailBatchId = $batchId;
    }

    public function hideDetail()
    {
        $this->detailBatchId = null;
    }
}
