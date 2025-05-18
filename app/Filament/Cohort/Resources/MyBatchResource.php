<?php

namespace App\Filament\Cohort\Resources;

use App\Models\Batch;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Actions\Action;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use App\Filament\Cohort\Resources\MyBatchResource\Pages;
use Illuminate\Database\Eloquent\Builder;

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
                Tables\Columns\TextColumn::make('kategori')->label('Kategori'),
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
                TextEntry::make('name')->label('Nama Batch'),
                TextEntry::make('kategori')->label('Kategori'),
                TextEntry::make('price')
                    ->label('Harga')
                    ->formatStateUsing(fn ($state) => $state ? 'Rp ' . number_format($state, 0, ',', '.') : 'Gratis'),
                TextEntry::make('duration')->label('Durasi (Menit)'),
                ImageEntry::make('thumbnail')
                    ->label('Thumbnail')
                    ->width(300)
                    ->height(100)
                    ->columnSpanFull(),
            ]);
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
