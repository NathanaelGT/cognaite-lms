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

    public function mount()
    {
        $this->batches = Batch::all();
        $this->joinedBatchIds = Auth::user()->batches->pluck('id')->toArray();
    }

    public function joinBatch($batchId)
    {
        $user = Auth::user();

        if (!$user->batches->contains($batchId)) {
            $user->batches()->attach($batchId);

            Notification::make()
                ->title('Berhasil bergabung batch!')
                ->success()
                ->send();

            $this->joinedBatchIds[] = $batchId;
        }
    }
}
