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
        return [
            Actions\Action::make('learn')
                ->label('Belajar Sekarang')
                ->icon('heroicon-o-book-open')
                ->url(fn () => MyBatchResource::getUrl('learn-material', [
                    'record' => $this->record->slug,
                    'post'   => $this->record->posts()->orderBy('order')->first()->slug,
                ]))
                ->visible(fn () => $this->record->posts()->exists()),
        ];
    }
}
