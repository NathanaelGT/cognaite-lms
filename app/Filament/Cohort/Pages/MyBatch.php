<?php

namespace App\Filament\Cohort\Pages;

use App\Models\Batch;
use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Placeholder;
use Filament\Notifications\Notification;
use Livewire\Features\SupportEvents\DispatchesEvents;

class MyBatch extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string $view = 'filament.cohort.pages.page';
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $title = 'Batch Saya';

    public function table(Tables\Table $table): Tables\Table
    {
        $user = Auth::user();

        return $table
            ->query(fn () => \App\Models\Batch::whereHas('users', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            }))
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->label('Thumbnail')
                    ->disk('public')
                    ->circular()
                    ->height(60)
                    ->width(60),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('kategori')
                    ->label('Kategori'),

                Tables\Columns\TextColumn::make('price')
                    ->label('Harga')
                    ->formatStateUsing(fn ($state) => $state ? 'Rp ' . number_format($state, 0, ',', '.') : 'Gratis'),

                Tables\Columns\TextColumn::make('duration')
                    ->label('Durasi (Menit)'),
            ])
            ->actions([
                Action::make('detail')
                    ->label('Detail')
                    ->icon('heroicon-o-eye')
                    ->form(fn (Batch $record) => [
                        TextInput::make('name')
                            ->label('Nama')
                            ->default($record->name)
                            ->disabled(),

                        Textarea::make('description')
                            ->label('Deskripsi')
                            ->default($record->description)
                            ->disabled(),

                        TextInput::make('kategori')
                            ->label('Kategori')
                            ->default($record->kategori)
                            ->disabled(),

                        TextInput::make('price')
                            ->label('Harga')
                            ->default($record->price ? 'Rp ' . number_format($record->price, 0, ',', '.') : 'Gratis')
                            ->disabled(),

                        TextInput::make('duration')
                            ->label('Durasi (Menit)')
                            ->default($record->duration)
                            ->disabled(),

                        Placeholder::make('posts')
                            ->label('Materi dalam Batch')
                            ->content(
                                fn () => $record->posts->count()
                                    ? $record->posts->pluck('title')->implode(', ')
                                    : 'Belum ada materi.'
                            ),
                    ])
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup'),

                Action::make('keluar')
                    ->label('Keluar')
                    ->icon('heroicon-o-x-circle')
                    ->requiresConfirmation()
                    ->color('danger')
                    ->action(function (Batch $record) use ($user) {
                        $user->batches()->detach($record->id);

                        Notification::make()
                            ->title('Berhasil')
                            ->body('Berhasil keluar dari Batch ' . $record->name)
                            ->success()
                            ->send();

                        $this->dispatch('refresh');
                    }),
            ])
            ->paginated();
    }
}
