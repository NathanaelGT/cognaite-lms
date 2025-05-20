<?php

namespace App\Filament\Cohort\Resources;

use App\Models\Batch;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Tables\Table;
use Filament\Tables;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Actions\Action;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use App\Filament\Cohort\Resources\MyBatchResource\Pages;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Split;
use Filament\Infolists\Components\TextEntry\TextEntrySize;
use Filament\Support\Enums\FontWeight;
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
                Tables\Columns\TextColumn::make('price')->label('Harga')
                    ->formatStateUsing(fn ($state) => $state ? 'Rp ' . number_format($state, 0, ',', '.') : 'Gratis'),
                Tables\Columns\TextColumn::make('duration')->label('Durasi (Menit)'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make('detail')
                    ->label('Detail')
                    ->icon('heroicon-o-eye'),
                Action::make('keluar')
                    ->label('Keluar')
                    ->icon('heroicon-o-x-circle')
                    ->requiresConfirmation()
                    ->color('danger')
                    ->action(function (Batch $record) use ($user) {
                        $user->batches()->detach($record->id);

                        \Filament\Notifications\Notification::make()
                            ->title('Berhasil')
                            ->body('Berhasil keluar dari Batch ' . $record->name)
                            ->success()
                            ->send();
                    }),
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
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('posts');
    }
}
