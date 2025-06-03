<?php

namespace App\Filament\Cohort\Resources;

use App\Filament\Cohort\Resources\MyBatchResource\Pages;
use App\Models\Batch;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Split;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\TextEntry\TextEntrySize;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;

class MyBatchResource extends Resource
{
    protected static ?string $model = Batch::class;
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationLabel = 'Batch Saya';
    protected static ?string $slug = 'my-batch';

    public static function table(Table $table): Table
    {
        $user = Auth::user();

        return $table
            ->query(
                Batch::whereHas('users', fn ($q) => $q->where('user_id', $user->id))
            )
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->label('Thumbnail')
                    ->disk('public')
                    ->circular()
                    ->height(60)
                    ->width(60),
                Tables\Columns\TextColumn::make('name')->label('Nama')->searchable(),
                Tables\Columns\TextColumn::make('duration')->label('Durasi (Menit)'),
                Tables\Columns\TextColumn::make('progress_percentage')
                    ->label('Progress')
                    ->formatStateUsing(function (Batch $record) {
                        $progress = $record->progress_percentage;
                        return new HtmlString('
                            <div style="width: 100%; background-color: #e5e7eb; border-radius: 9999px; height: 10px; margin-bottom: 5px;">
                                <div style="width: '.$progress.'%; background-color: rgb(217, 119, 6); height: 100%; border-radius: 9999px;"></div>
                            </div>
                            <div style="font-size: 0.875rem; color: rgb(55, 65, 81); text-align: center;">
                                '.$progress.'% selesai
                            </div>
                        ');
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make('detail')
                    ->label('Detail')
                    ->icon('heroicon-o-eye'),
                Action::make('learn')
                    ->label('Belajar Sekarang')
                    ->icon('heroicon-o-book-open')
                    ->url(fn (Batch $record) => MyBatchResource::getUrl('learn-material', [
                        'record' => $record->slug,
                        'post' => optional($record->posts()->orderBy('order')->first())->slug,
                    ]))
                    ->visible(fn (Batch $record) => $record->posts()->exists()),
            ])
            ->paginated();
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make(function (Batch $record) {
                    return new HtmlString('<img src="' . Storage::disk('public')->url($record->thumbnail) . '" class="max-w-none object-cover object-center ml-auto" style="height: 250px; width: 250px;">');
                })
                    ->aside()
                    ->schema([
                        Split::make([
                            TextEntry::make('name')
                                ->hiddenLabel()
                                ->size(TextEntrySize::Large)
                                ->weight(FontWeight::Bold)
                                ->columnSpanFull()
                                ->alignment(Alignment::Start),

                            TextEntry::make('price')
                                ->hiddenLabel()
                                ->formatStateUsing(fn ($state) => $state ? 'Rp ' . number_format($state, 0, ',', '.') : 'Gratis')
                                ->alignment(Alignment::End),
                        ]),

                        TextEntry::make('duration')
                            ->label('Durasi')
                            ->icon('heroicon-o-clock')
                            ->suffix(' Menit'),

                        TextEntry::make('progress_percentage')
                            ->label('Progress Pembelajaran')
                            ->formatStateUsing(function ($state, Batch $record) {
                                $progress = $record->progress_percentage;
                                return new HtmlString('
                                    <div style="margin-top: 1rem;">
                                        <div style="
                                            width: 100%;
                                            height: 10px;
                                            background-color: #e5e7eb;
                                            border-radius: 9999px;
                                            overflow: hidden;
                                        ">
                                            <div style="
                                                width: '.$progress.'%;
                                                height: 100%;
                                                background-color: rgb(217, 119, 6);
                                                border-radius: 9999px;
                                            "></div>
                                        </div>
                                        <p style="
                                            text-align: center;
                                            font-size: 0.875rem;
                                            color: rgb(55, 65, 81);
                                            margin-top: 0.5rem;
                                        ">
                                            '.$progress.'% selesai
                                        </p>
                                    </div>
                                ');
                            }),

                        TextEntry::make('description')
                            ->label('Deskripsi')
                            ->markdown(),
                    ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            MyBatchResource\RelationManagers\MaterialsRelationManager::class,
            MyBatchResource\RelationManagers\SubmissionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMyBatches::route('/'),
            'view' => Pages\ViewMyBatch::route('/{record}'),
            'learn-material' => Pages\LearnMaterial::route('/{record}/materi/{post}'),
            'quiz' => Pages\Quiz::route('/{record}/quiz/{post}'),
            'submission' => Pages\SubmissionPage::route('/{record}/submission/{post}'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['posts', 'users' => function($query) {
                $query->where('user_id', auth()->id());
            }]);
    }
}
