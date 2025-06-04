<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\BatchResource\Pages;
use App\Filament\Admin\Resources\BatchResource\Pages\Assessment;
use App\Filament\Admin\Resources\BatchResource\RelationManagers\PostsRelationManager;
use App\Models\Batch;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Support\RawJs;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;

class BatchResource extends Resource
{
    protected static ?string $model = Batch::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(3)->schema([
                    TextInput::make('name')
                        ->label('Nama')
                        ->placeholder('Masukkan Nama Batch')
                        ->required()
                        ->maxLength(255),

                    TextInput::make('price')
                        ->label('Harga')
                        ->placeholder('Masukkan Harga')
                        ->prefix('Rp')
                        ->mask(RawJs::make('$money($input, \',\', \'.\')'))
                        ->dehydrateStateUsing(fn ($state) => (int) str()->replace('.', '', $state))
                        ->maxValue(1_000_000_000)
                        ->hiddenOn('view'),

                    TextInput::make('duration')
                        ->label('Durasi')
                        ->placeholder('Masukkan Durasi')
                        ->suffix('Menit')
                        ->numeric()
                        ->required()
                        ->minValue(1)
                        ->maxValue(1_000_000_000)
                        ->hiddenOn('view'),
                ]),

                RichEditor::make('description')
                    ->label('Deskripsi')
                    ->placeholder('Masukkan Deskripsi')
                    ->required()
                    ->columnSpanFull()
                    ->hiddenOn('view'),

                FileUpload::make('thumbnail')
                    ->label('Thumbnail')
                    ->image()
                    ->imageEditor()
                    ->disk('public')
                    ->directory('thumbnails')
                    ->visibility('public')
                    ->required()
                    ->preserveFilenames()
                    ->imagePreviewHeight('200')
                    ->columnSpanFull()
                    ->hiddenOn('view'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('thumbnail')
                    ->label('Thumbnail')
                    ->url(fn ($record) => asset('storage/' . $record->thumbnail))
                    ->height(80)
                    ->width(80),

                TextColumn::make('name')
                    ->label('Nama Batch')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('price')
                    ->label('Harga')
                    ->formatStateUsing(fn ($state) => $state ? 'Rp ' . number_format($state, 0, ',', '.') . ',-' : 'Gratis')
                    ->sortable(),

                TextColumn::make('duration')
                    ->label('Durasi')
                    ->suffix(' Menit')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime('j F Y \P\u\k\u\l H:i')
                    ->sortable(),

                TextColumn::make('updated_at')
                    ->label('Terakhir Diperbarui')
                    ->dateTime('j F Y \P\u\k\u\l H:i')
                    ->sortable(),
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
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            BatchResource\RelationManagers\PostsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBatches::route('/'),
            'create' => Pages\CreateBatch::route('/create'),
            'edit' => Pages\EditBatch::route('/{record}/edit'),
            'view' => Pages\ViewBatch::route('/{record}'),
            'assessment' => Pages\Assessment::route('/{record}/{assessment}'),
        ];
    }
}
