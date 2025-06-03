<?php

namespace App\Filament\Cohort\Resources\MyBatchResource\Pages;

use App\Filament\Cohort\Resources\MyBatchResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewMyBatch extends ViewRecord
{
    protected static string $resource = MyBatchResource::class;

    protected function getHeaderActions(): array
    {
        $user = auth()->user();
        $lastAccessedPost = $user->getLastAccessedPost($this->record->id);
        $isBatchCompleted = $user->isCompletedBatch($this->record->id);
        $isFirstTime = !$lastAccessedPost && !$isBatchCompleted;

        return [
            Actions\Action::make('learn')
                ->label($isBatchCompleted ? 'Belajar Kembali' :
                    ($isFirstTime ? 'Belajar Sekarang' : 'Lanjutkan Belajar'))
                ->icon('heroicon-o-book-open')
                ->url(function () use ($lastAccessedPost, $isBatchCompleted) {
                    if ($isBatchCompleted) {
                        return MyBatchResource::getUrl('learn-material', [
                            'record' => $this->record->slug,
                            'post' => $this->record->posts()->orderBy('order')->first()->slug,
                        ]);
                    }

                    if ($lastAccessedPost) {
                        return match ($lastAccessedPost->type) {
                            'quiz' => MyBatchResource::getUrl('quiz', [
                                'record' => $this->record->slug,
                                'post' => $lastAccessedPost->slug,
                            ]),
                            'submission' => MyBatchResource::getUrl('submission', [
                                'record' => $this->record->slug,
                                'post' => $lastAccessedPost->slug,
                            ]),
                            default => MyBatchResource::getUrl('learn-material', [
                                'record' => $this->record->slug,
                                'post' => $lastAccessedPost->slug,
                            ]),
                        };
                    }

                    return MyBatchResource::getUrl('learn-material', [
                        'record' => $this->record->slug,
                        'post' => $this->record->posts()->orderBy('order')->first()->slug,
                    ]);
                })
                ->visible(fn () => $this->record->posts()->exists()),
        ];
    }
}
