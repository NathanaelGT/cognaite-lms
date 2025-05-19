<?php

namespace App\Filament\Cohort\Resources\MyBatchResource\Pages;

use App\Filament\Cohort\Resources\MyBatchResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Tables\Components\Table as TableComponent;
use Filament\Tables\Components\TextColumn;

class ViewMyBatch extends ViewRecord
{
    protected static string $resource = MyBatchResource::class;

    public function getViewContent(): array
    {
        $record = $this->getRecord();

        return [
            // Detail batch
            Infolist::make()
                ->record($record)
                ->schema([
                    TextEntry::make('name')->label('Nama Batch'),
                    TextEntry::make('price')
                        ->label('Harga')
                        ->formatStateUsing(fn ($state) => $state ? 'Rp ' . number_format($state, 0, ',', '.') : 'Gratis'),
                    TextEntry::make('duration')->label('Durasi (Menit)'),
                    ImageEntry::make('thumbnail')
                        ->label('Thumbnail')
                        ->width(300)
                        ->height(100)
                        ->columnSpanFull(),
                ]),

            TableComponent::make()
                ->heading('Daftar Materi / Post')
                ->records($record->posts)
                ->columns([
                    TextColumn::make('title')->label('Judul'),
                    TextColumn::make('description')->label('Deskripsi')->html(),
                    TextColumn::make('min_score')->label('Nilai Minimal')->default('-'),
                ]),
        ];
    }
}
