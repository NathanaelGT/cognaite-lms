<?php

namespace App\Filament\Cohort\Resources\MyBatchResource\Pages;

use App\Filament\Cohort\Resources\MyBatchResource;
use App\Models\Batch;
use App\Models\ForumThread;
use Filament\Actions\Action;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\Auth;

class ForumList extends Page
{
    protected static string $resource = MyBatchResource::class;
    protected static string $view = 'filament.cohort.my-batch-resource.pages.forum.forum-list';

    public Batch $record;

    public string $mode = 'all';
    public string $order = 'latest';
    public ?int $postId = null;

    public function mount(Batch $record): void
    {
        $this->record = $record;
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Kembali ke Kelas')
                ->icon('heroicon-o-arrow-long-left')
                ->url(fn () => MyBatchResource::getUrl('view', [
                    'record' => $this->record->slug,
                ])),

            Action::make('create')
                ->label('Buat Diskusi')
                ->icon('heroicon-o-plus')
                ->color('primary')
                ->url(fn () => MyBatchResource::getUrl('forum-create', [
                    'record' => $this->record->slug,
                ])),
        ];
    }

    public function getThreads()
    {
        $query = ForumThread::query()
            ->where('batch_id', $this->record->id);

        if ($this->mode === 'mine') {
            $query->where('user_id', auth()->id());
        }

        if ($this->postId) {
            $query->where('post_id', $this->postId);
        }

        return $this->order === 'oldest'
            ? $query->oldest()->get()
            : $query->latest()->get();
    }

    public function getMyThreads()
    {
        return ForumThread::with(['user'])
            ->where('batch_id', $this->record->id)
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);
    }
}
