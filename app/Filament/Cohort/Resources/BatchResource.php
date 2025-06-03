<?php

namespace App\Filament\Cohort\Resources;

use App\Enums\BatchUserStatus;
use App\Enums\TransactionStatus;
use App\Filament\Cohort\Pages\Pay;
use App\Filament\Cohort\Resources\BatchResource\Pages;
use App\Filament\Cohort\Resources\BatchResource\RelationManagers;
use App\Filament\Cohort\Resources\MyBatchResource;
use App\Models\Batch;
use App\Models\Transaction;
use Filament\Infolists;
use Filament\Infolists\Components\TextEntry\TextEntrySize;
use Filament\Infolists\Infolist;
use Filament\Notifications;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use Filament\Panel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;
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
                Tables\Columns\Layout\Stack::make([
                    Tables\Columns\ImageColumn::make('thumbnail')
                        ->disk('public')
                        ->label('Thumbnail')
                        ->size(200)
                        ->alignment(Alignment::Center),

                    Tables\Columns\TextColumn::make('name')
                        ->label('Nama Batch')
                        ->searchable()
                        ->formatStateUsing(fn ($state) => new HtmlString('<p class="text-xl my-2 font-bold">' . e($state) . '</p>'))
                        ->alignment(Alignment::Center),

                    Tables\Columns\Layout\Split::make([
                        Tables\Columns\TextColumn::make('price')
                            ->label('Harga')
                            ->formatStateUsing(fn ($state) => $state ? 'Rp ' . number_format($state, 0, ',', '.') : 'Gratis')
                            ->alignment(Alignment::Start)
                            ->size(TextColumnSize::ExtraSmall),

                        Tables\Columns\TextColumn::make('posts_count')
                            ->label('Unggahan')
                            ->counts('posts')
                            ->formatStateUsing(fn ($state) => number_format($state, 0, ',', '.') . ' Unggahan')
                            ->alignment(Alignment::Center)
                            ->size(TextColumnSize::ExtraSmall),

                        Tables\Columns\TextColumn::make('duration')
                            ->label('Durasi')
                            ->suffix(' Menit')
                            ->alignment(Alignment::End)
                            ->size(TextColumnSize::ExtraSmall),
                    ]),

                    Tables\Columns\TextColumn::make('description')
                        ->label('Deskripsi')
                        ->markdown()
                        ->searchable()
                        ->formatStateUsing(fn ($state) => new HtmlString('<div class="my-4">' . $state . '</div>'))
                        ->alignment(Alignment::Justify),
                ]),
            ])
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
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

                            activity()
                                ->causedBy($user)
                                ->performedOn($record)
                                ->log('Join batch');

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
            ->paginated([12])
            ->modifyQueryUsing(function (Builder $query) {
                $query->whereDoesntHave('users', function (Builder $query) {
                    $query->where('user_id', Auth::id());
                });
            })
            ->recordUrl(fn () => null);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make(function (Batch $record) {
                    $record->loadCount('users');

                    return new HtmlString('<img src="' . Storage::disk('public')->url($record->thumbnail) . '" class="max-w-none object-cover object-center ml-auto" style="height: 200px; width: 200px;">');
                })
                    ->aside()
                    ->schema([
                        Infolists\Components\Split::make([
                            Infolists\Components\TextEntry::make('name')
                                ->hiddenLabel()
                                ->size(TextEntrySize::Large)
                                ->weight(FontWeight::Bold)
                                ->columnSpanFull()
                                ->alignment(Alignment::Start),

                            Infolists\Components\TextEntry::make('price')
                                ->hiddenLabel()
                                ->formatStateUsing(fn ($state) => $state ? 'Rp ' . number_format($state, 0, ',', '.') : 'Gratis')
                                ->alignment(Alignment::End),
                        ]),

                        Infolists\Components\TextEntry::make('duration')
                            ->suffix(' Menit Belajar')
                            ->hiddenLabel(),

                        Infolists\Components\TextEntry::make('users_count')
                            ->suffix(' Siswa Terdaftar')
                            ->hiddenLabel(),

                        Infolists\Components\TextEntry::make('description')
                            ->hiddenLabel()
                            ->markdown(),
                    ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\PostsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBatchResource::route('/'),
            'view' => Pages\ViewBatchResource::route('/{record}'),
        ];
    }
}
