<?php

namespace App\Filament\Cohort\Resources\MyBatchResource\Pages;

use App\Filament\Cohort\Resources\MyBatchResource;
use App\Models\Batch;
use App\Models\ForumThread;
use App\Models\ForumReply;
use Filament\Actions\Action;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\Auth;

class ShowThread extends Page
{
    protected static string $resource = MyBatchResource::class;
    protected static string $view = 'filament.cohort.my-batch-resource.pages.forum.show-thread';

    public Batch $record;
    public ForumThread $thread;
    public string $message = '';
    public string $order = 'oldest';

    public function mount(Batch $record, ForumThread $thread): void
    {
        $this->record = $record;
        $this->thread = $thread;
    }

    public function send(): void
    {
        ForumReply::create([
            'forum_thread_id' => $this->thread->id,
            'user_id' => auth()->id(),
            'content' => $this->message,
        ]);

        $this->message = '';
    }

    public function getReplies()
    {
        return $this->order === 'oldest'
            ? $this->thread->replies()->oldest()->get()
            : $this->thread->replies()->latest()->get();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Kembali ke Forum')
                ->icon('heroicon-o-arrow-left')
                ->url(
                    MyBatchResource::getUrl('forum', [
                        'record' => $this->record->slug,
                    ])
                ),
        ];
    }
}
