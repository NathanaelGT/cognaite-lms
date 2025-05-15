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
use Filament\Notifications\Notification;

class ResourceList extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string $view = 'filament.cohort.pages.page';
    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $title = 'Daftar Batch';

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->query(Batch::query())
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->label('Thumbnail')
                    ->disk('public')
                    ->circular()
                    ->height(60)
                    ->width(60),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Batch')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('kategori')
                    ->label('Kategori'),

                Tables\Columns\TextColumn::make('price')
                    ->label('Harga')
                    ->formatStateUsing(fn($state) => $state ? 'Rp ' . number_format($state, 0, ',', '.') : 'Gratis'),

                Tables\Columns\TextColumn::make('duration')
                    ->label('Durasi')
                    ->suffix(' Menit')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kategori')
                    ->options([
                        'gratis' => 'Gratis',
                        'berbayar' => 'Berbayar',
                    ])
                    ->label('Kategori'),
            ])
            ->actions([
                Action::make('gabung')
                    ->label('Gabung')
                    ->icon('heroicon-o-plus')
                    ->requiresConfirmation()
                    ->color('success')
                    ->action(function (Batch $record) {
                        $user = Auth::user();

                        if (!$user->batches->contains($record->id)) {
                            $user->batches()->attach($record->id);

                            Notification::make()
                                ->title('Berhasil')
                                ->body('Berhasil bergabung ke batch: ' . $record->name)
                                ->success()
                                ->send();
                        } else {
                            Notification::make()
                                ->title('Peringatan')
                                ->body('Kamu sudah tergabung di batch ini.')
                                ->warning()
                                ->send();
                        }
                    })
                    ->after(fn () => redirect()->route('filament.cohort.pages.my-batch')),

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
                    ])
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup'),
            ])
            ->paginated();
    }
}
