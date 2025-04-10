<?php

namespace App\Filament\Cohort\Pages;

use App\Models\Batch;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;

class ResourceList extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static string $view = 'filament.cohort.pages.resource-list';

    public $batches;
    public $joinedBatchIds = [];

    public $confirmingBatchId = null;
    public $batchToJoin = null;

    public $detailBatchId = null;

    public function mount()
    {
        $this->batches = Batch::with('courses')->get();
        $this->joinedBatchIds = Auth::user()->batches->pluck('id')->toArray();
    }

    public function startConfirmJoin($batchId)
    {
        $batch = Batch::findOrFail($batchId);

        // Kalau batch gratis, tampilkan modal konfirmasi
        if ($batch->price === '0' || $batch->price === null || strtolower($batch->price) === 'gratis') {
            $this->confirmingBatchId = $batchId;
            $this->batchToJoin = $batch;
        } else {
            // Kalau batch berbayar, redirect ke halaman payment dummy
            redirect()->to(route('filament.cohort.pages.payment', ['batch' => $batch->id]));
        }
    }

    public function confirmJoin()
    {
        $batch = Batch::findOrFail($this->confirmingBatchId);
        $user = Auth::user();

        if (! $user->batches()->where('batch_id', $batch->id)->exists()) {
            $user->batches()->attach($batch->id);
            $this->joinedBatchIds[] = $batch->id;

            Notification::make()
                ->title("Berhasil bergabung batch: {$batch->name}")
                ->success()
                ->send();
        }

        $this->confirmingBatchId = null;
        $this->batchToJoin = null;
    }

    public function cancelConfirm()
    {
        $this->confirmingBatchId = null;
        $this->batchToJoin = null;
    }

    public function toggleDetail($batchId)
    {
        $this->expandedBatchId = $this->expandedBatchId === $batchId ? null : $batchId;
    }
}
