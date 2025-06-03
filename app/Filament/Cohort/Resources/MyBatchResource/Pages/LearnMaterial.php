<?php

namespace App\Filament\Cohort\Resources\MyBatchResource\Pages;

use App\Filament\Cohort\Resources\MyBatchResource;
use App\Models\Batch;
use App\Models\Post;
use App\Models\UserPostProgress;
use Filament\Actions;
use Filament\Infolists\Components\Actions as InfolistActions;
use Filament\Infolists\Components\Actions\Action;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\TextEntry\TextEntrySize;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\Page;
use Filament\Support\Enums\FontWeight;
use Illuminate\Support\Facades\Auth;

class LearnMaterial extends Page
{
    protected static string $resource = MyBatchResource::class;
    protected static string $view = 'filament.cohort.my-batch-resource.pages.learn-material';

    public Post $post;
    public Batch $record;

    public function mount(Batch $record, Post $post): void
    {
        $this->record = $record;
        $this->post = $post;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('back')
                ->label('Kembali')
                ->icon('heroicon-o-arrow-long-left')
                ->url(fn () => MyBatchResource::getUrl('view', [
                    'record' => $this->record->slug,
                ])),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->record($this->post)
            ->schema([
                TextEntry::make('title')
                    ->columnSpanFull()
                    ->hiddenLabel()
                    ->weight(FontWeight::Bold)
                    ->size(TextEntrySize::Large),

                TextEntry::make('content')
                    ->hiddenLabel()
                    ->columnSpanFull()
                    ->size(TextEntrySize::Large)
                    ->alignJustify('center')
                    ->markdown(),

                InfolistActions::make([
                    Action::make('prev')
                        ->label('Sebelumnya')
                        ->icon('heroicon-o-arrow-left')
                        ->url(function () {
                            $prevPost = $this->getPreviousPost();
                            if (! $prevPost) {
                                return null;
                            }

                            return match ($prevPost->type) {
                                'quiz' => MyBatchResource::getUrl('quiz', [
                                    'record' => $this->record->slug,
                                    'post' => $prevPost->slug,
                                ]),
                                'submission' => MyBatchResource::getUrl('submission', [
                                    'record' => $this->record->slug,
                                    'post' => $prevPost->slug,
                                ]),
                                default => MyBatchResource::getUrl('learn-material', [
                                    'record' => $this->record->slug,
                                    'post' => $prevPost->slug,
                                ]),
                            };
                        })
                        ->disabled(fn () => ! $this->getPreviousPost())
                        ->color('primary'),

                    Action::make('next')
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
                            if (! $nextPost) {
                                return null;
                            }

                            return match ($nextPost->type) {
                                'quiz' => MyBatchResource::getUrl('quiz', [
                                    'record' => $this->record->slug,
                                    'post' => $nextPost->slug,
                                ]),
                                'submission' => MyBatchResource::getUrl('submission', [
                                    'record' => $this->record->slug,
                                    'post' => $nextPost->slug,
                                ]),
                                default => MyBatchResource::getUrl('learn-material', [
                                    'record' => $this->record->slug,
                                    'post' => $nextPost->slug,
                                ]),
                            };
                        })
                        ->disabled(fn () => ! $this->getNextPost())
                        ->color('primary')
                        ->visible(fn () => (bool) $this->getNextPost()),

                    Action::make('finish')
                        ->label('Selesai')
                        ->icon('heroicon-o-check')
                        ->url(MyBatchResource::getUrl('view', [
                            'record' => $this->record->slug,
                        ]))
                        ->color('success')
                        ->visible(fn () => ! $this->getNextPost()),
                ])
                    ->alignBetween()
                    ->columnSpanFull(),
            ]);
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
}
