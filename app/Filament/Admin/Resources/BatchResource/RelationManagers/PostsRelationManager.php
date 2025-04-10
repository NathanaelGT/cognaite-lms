<?php

namespace App\Filament\Admin\Resources\BatchResource\RelationManagers;

use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PostsRelationManager extends RelationManager
{
    protected static string $relationship = 'posts';
    protected static ?string $title = 'Postingan';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Wizard::make([
                    Forms\Components\Wizard\Step::make('Jenis')->schema([
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\TextInput::make('title')
                                ->label('Judul')
                                ->placeholder('Masukkan Judul')
                                ->required()
                                ->maxLength(255),

                            Forms\Components\Select::make('type')
                                ->label('Jenis')
                                ->options([
                                    'material' => 'Materi',
                                    'submission' => 'Tugas',
                                ])
                                ->searchable()
                                ->required()
                        ]),
                    ]),
                    
                    Forms\Components\Wizard\Step::make('Detail')->schema([
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\TextInput::make('min_score')
                                ->label('Nilai Minimum')
                                ->placeholder('Masukkan Nilai Minimum')
                                ->numeric()
                                ->visible(fn (Get $get) => $get('type') === 'submission')
                                ->required()
                                ->minValue(0)
                                ->maxValue(100),

                            Forms\Components\RichEditor::make('description')
                                ->label('Deskripsi')
                                ->placeholder('Masukkan Deskripsi')
                                ->required()
                                ->columnSpanFull(),
                        ]),
                    ]),
                ])->columnSpanFull()
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->reorderable('order')
            ->defaultSort('order')
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('order')
                    ->label('Urutan')
                    ->sortable(),

                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->sortable(),

                Tables\Columns\TextColumn::make('id')
                    ->label('Jenis')
                    ->formatStateUsing(fn (Post $post) => $post->min_score === null ? 'Materi' : 'Tugas')
                    ->badge()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('min_score')
                    ->label('Nilai Minimum')
                    ->placeholder('-')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime('j F Y \P\u\k\u\l H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Terakhir Diperbarui')
                    ->dateTime('j F Y \P\u\k\u\l H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
