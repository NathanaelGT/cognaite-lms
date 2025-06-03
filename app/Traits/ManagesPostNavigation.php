<?php

namespace App\Traits;

use App\Filament\Cohort\Resources\MyBatchResource;
use App\Models\Batch;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use App\Models\UserPostProgress;
use Filament\Forms\Components\Actions\Action as FormAction;
use Filament\Infolists\Components\Actions\Action as InfolistAction;

trait ManagesPostNavigation
{
    public Batch $record;
    public Post $post;
    public $progressPercentage;

    protected function commonMount(Batch $record, Post $post): void
    {
        $this->record = $record;
        $this->post = $post;

        $totalPosts = $record->posts()->count();
        $completedPosts = auth()->user()->postProgress()
            ->whereIn('post_id', $record->posts()->pluck('id'))
            ->where('is_completed', true)
            ->count();

        $this->progressPercentage = $totalPosts > 0 ? round(($completedPosts / $totalPosts) * 100) : 0;
    }

    protected function getCommonHeaderActions(): array
    {
        return [
            \Filament\Actions\Action::make('back')
                ->label('Kembali')
                ->icon('heroicon-o-arrow-long-left')
                ->url(fn () => MyBatchResource::getUrl('view', [
                    'record' => $this->record->slug,
                ])),
        ];
    }

    protected function getPostUrl(Post $post): string
    {
        return match ($post->type) {
            'quiz' => MyBatchResource::getUrl('quiz', [
                'record' => $this->record->slug,
                'post' => $post->slug,
            ]),
            'submission' => MyBatchResource::getUrl('submission', [
                'record' => $this->record->slug,
                'post' => $post->slug,
            ]),
            default => MyBatchResource::getUrl('learn-material', [
                'record' => $this->record->slug,
                'post' => $post->slug,
            ]),
        };
    }

    protected function getPreviousPost(): ?Post
    {
        return $this->record->posts()
            ->where('order', '<', $this->post->order)
            ->orderBy('order', 'desc')
            ->first();
    }

    protected function getNextPost(): ?Post
    {
        return $this->record->posts()
            ->where('order', '>', $this->post->order)
            ->orderBy('order', 'asc')
            ->first();
    }

    protected function getCommonInfolistNavigationActions(): array
    {
        return [
            InfolistAction::make('prev')
                ->label('Sebelumnya')
                ->icon('heroicon-o-arrow-left')
                ->url(fn () => $this->getPreviousPost() ? $this->getPostUrl($this->getPreviousPost()) : null)
                ->disabled(fn () => !$this->getPreviousPost())
                ->color('primary'),

            InfolistAction::make('next')
                ->icon('heroicon-o-arrow-right')
                ->label('Selanjutnya')
                ->iconPosition('after')
                ->url(function () {
                    UserPostProgress::updateOrCreate(
                        [
                            'user_id' => Auth::id(),
                            'post_id' => $this->post->id,
                        ],
                        [
                            'is_completed' => true,
                            'is_passed' => true,
                        ]
                    );

                    $nextPost = $this->getNextPost();
                    if (!$nextPost) {
                        return null;
                    }

                    return $this->getPostUrl($nextPost);
                })
                ->disabled(fn () => !$this->getNextPost())
                ->color('primary')
                ->visible(fn () => (bool) $this->getNextPost()),

            InfolistAction::make('finish')
                ->label('Selesai')
                ->icon('heroicon-o-check')
                ->url(MyBatchResource::getUrl('view', [
                    'record' => $this->record->slug,
                ]))
                ->color('success')
                ->visible(fn () => !$this->getNextPost()),
        ];
    }

    protected function getCommonFormNavigationActions(): array
    {
        return [
            FormAction::make('prev')
                ->label('Sebelumnya')
                ->icon('heroicon-o-arrow-left')
                ->url(fn () => $this->getPreviousPost() ? $this->getPostUrl($this->getPreviousPost()) : null)
                ->disabled(fn () => !$this->getPreviousPost())
                ->color('primary'),

            FormAction::make('next')
                ->icon('heroicon-o-arrow-right')
                ->label('Selanjutnya')
                ->iconPosition('after')
                ->url(function () {
                    UserPostProgress::updateOrCreate(
                        [
                            'user_id' => Auth::id(),
                            'post_id' => $this->post->id,
                        ],
                        [
                            'is_completed' => true,
                            'is_passed' => true,
                        ]
                    );

                    $nextPost = $this->getNextPost();
                    if (!$nextPost) {
                        return null;
                    }

                    return $this->getPostUrl($nextPost);
                })
                ->disabled(fn () => !$this->getNextPost())
                ->color('primary')
                ->visible(fn () => (bool) $this->getNextPost()),

            FormAction::make('finish')
                ->label('Selesai')
                ->icon('heroicon-o-check')
                ->url(MyBatchResource::getUrl('view', [
                    'record' => $this->record->slug,
                ]))
                ->color('success')
                ->visible(fn () => !$this->getNextPost()),
        ];
    }
}
