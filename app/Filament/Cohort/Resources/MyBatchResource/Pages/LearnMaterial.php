<?php

namespace App\Filament\Cohort\Resources\MyBatchResource\Pages;

use App\Filament\Cohort\Resources\MyBatchResource;
use App\Models\Batch;
use App\Models\Post;
use Filament\Infolists\Components\Actions as InfolistActions;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\TextEntry\TextEntrySize;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\Page;
use Filament\Support\Enums\FontWeight;
use App\Traits\ManagesPostNavigation;

class LearnMaterial extends Page
{
    use ManagesPostNavigation;

    protected static string $resource = MyBatchResource::class;
    protected static string $view = 'filament.cohort.my-batch-resource.pages.learn-material';

    public function mount(Batch $record, Post $post): void
    {
        $this->commonMount($record, $post);
    }

    protected function getHeaderActions(): array
    {
        return $this->getCommonHeaderActions();
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

                InfolistActions::make(
                    $this->getCommonInfolistNavigationActions()
                )
                    ->alignBetween()
                    ->columnSpanFull(),
            ]);
    }
}
