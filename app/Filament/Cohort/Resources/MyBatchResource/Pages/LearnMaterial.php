<?php

namespace App\Filament\Cohort\Resources\MyBatchResource\Pages;

use App\Filament\Cohort\Resources\MyBatchResource;
use App\Models\Batch;
use App\Models\Post;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\TextEntry\TextEntrySize;
use Filament\Resources\Pages\Page;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Enums\FontWeight;
use Illuminate\Support\Facades\Auth;
use Filament\Infolists\Infolist;
use Filament\Actions;
use Filament\Infolists\Components\Actions\Action;
use Filament\Infolists\Components\Actions as InfolistActions;

class LearnMaterial extends ViewRecord
{
    protected static string $resource = MyBatchResource::class;
    protected static string $view = 'filament.cohort.my-batch-resource.pages.learn-material';

    public Post $post;

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
                            $previousPost = $this->getPreviousPost();
                            return $previousPost ? MyBatchResource::getUrl('learn-material', [
                                'record' => $this->record->slug,
                                'post' => $previousPost->slug,
                            ]) : null;
                        })
                        ->disabled(fn () => !$this->getPreviousPost())
                        ->color('primary'),

                    Action::make('next')
                        ->icon('heroicon-o-arrow-right')
                        ->label('Selanjutnya')
                        ->iconPosition('after')
                        ->url(function () {
                            $nextPost = $this->getNextPost();
                            return $nextPost ? MyBatchResource::getUrl('learn-material', [
                                'record' => $this->record->slug,
                                'post' => $nextPost->slug,
                            ]) : null;
                        })
                        ->disabled(fn () => !$this->getNextPost())
                        ->color('primary')
                        ->visible(fn () => (bool) $this->getNextPost()),

                    Action::make('finish')
                        ->label('Selesai')
                        ->icon('heroicon-o-check')
                        ->url(MyBatchResource::getUrl('view', [
                            'record' => $this->record->slug
                        ]))
                        ->color('success')
                        ->visible(fn () => !$this->getNextPost())
                        ->action(function () {
                            $progress = \App\Models\BatchUserProgress::updateOrCreate(
                                [
                                    'user_id' => Auth::id(),
                                    'batch_id' => $this->record->id,
                                ],
                                [
                                    'completed_posts' => $this->record->posts()->count(),
                                ]
                            );

                            return redirect(MyBatchResource::getUrl('view', [
                                'record' => $this->record->slug,
                            ]));
                        }),
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

    public function getRelationManagers(): array
    {
        return [];
    }
}
