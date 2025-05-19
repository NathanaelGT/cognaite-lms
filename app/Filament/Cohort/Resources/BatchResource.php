<?php

namespace App\Filament\Cohort\Resources;

use App\Enums\BatchUserStatus;
use App\Enums\TransactionStatus;
use App\Filament\Cohort\Pages\Pay;
use App\Filament\Cohort\Resources\BatchResource\Pages;
use App\Models\Batch;
use App\Models\Transaction;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Notifications;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BatchResource extends Resource
{
    protected static ?string $model = Batch::class;
    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationLabel = 'Daftar Batch';
    protected static ?string $slug = 'resource-list';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->disk('public')
                    ->label('Thumbnail')
                    ->size(70),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Batch')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Harga')
                    ->formatStateUsing(fn ($state) => $state ? 'Rp ' . number_format($state, 0, ',', '.') : 'Gratis'),
                Tables\Columns\TextColumn::make('duration')->label('Durasi')->suffix(' Menit'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('price')
                    ->label('Jenis')
                    ->modifyQueryUsing(function (Builder $query, $state) {
                        $operator = match ($state['value']) {
                            'g' => '=',
                            'b' => '!=',
                            default => null,
                        };

                        if ($operator) {
                            $query->where('price', $operator, 0);
                        }
                    })
                    ->options(['g' => 'Gratis', 'b' => 'Berbayar']),
            ])
            ->actions([
                Action::make('gabung')
                    ->label('Gabung')
                    ->icon('heroicon-o-plus')
                    ->requiresConfirmation()
                    ->color('success')
                    ->action(function (Batch $record, Pages\ListBatchResource $livewire) {
                        $user = Auth::user();

                        if ($user->batches()->where('batches.id', $record->id)->exists()) {
                            Notifications\Notification::make()
                                ->title('Peringatan')
                                ->body('Kamu sudah tergabung di batch ini.')
                                ->warning()
                                ->send();

                            return;
                        }

                        if ($record->price === 0) {
                            $user->batches()->attach($record->id);

                            $livewire->redirect(MyBatchResource::getUrl('view', [$record]));
                        } else {
                            $transaction = $user->transactions()
                                ->where('batch_id', $record->id)
                                ->firstOr(callback: function () use ($user, $record) {
                                    return $user->transactions()->create([
                                        'id' => $id = Str::uuid7()->toString(),
                                        'batch_id' => $record->id,
                                        'price' => $record->price,
                                        'status' => TransactionStatus::Pending,
                                        'snap_token' => Transaction::getSnapToken($id, $record),
                                    ]);
                                });

                            $livewire->redirectRoute('pay', [$transaction]);
                        }
                    }),
                Tables\Actions\ViewAction::make('detail')
                    ->label('Detail')
                    ->icon('heroicon-o-eye'),
            ])
            ->paginated()
            ->modifyQueryUsing(function (Builder $query) {
                $query->whereDoesntHave('users', function (Builder $query) {
                    $query->where('user_id', Auth::id());
                });
            });
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\TextEntry::make('name')
                    ->label('Nama Batch'),

                Infolists\Components\TextEntry::make('price')
                    ->label('Harga')
                    ->formatStateUsing(fn ($state) => $state ? 'Rp ' . number_format($state, 0, ',', '.') : 'Gratis'),

                Infolists\Components\TextEntry::make('duration')
                    ->label('Durasi (Menit)'),

                Infolists\Components\ImageEntry::make('thumbnail')
                    ->label('Thumbnail')
                    ->width(300)
                    ->height(100)
                    ->columnSpanFull(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBatchResource::route('/'),
            'view' => Pages\ViewBatchResource::route('/{record}'),
        ];
    }
}
