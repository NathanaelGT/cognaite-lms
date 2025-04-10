<?php

namespace App\Filament\Admin\Resources\BatchResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\RichEditor;
use Filament\Infolists\Components\Tabs;
use Filament\Forms\Components\Grid;

class SubmissionRelationManager extends RelationManager
{
    protected static string $relationship = 'posts';
    protected static ?string $title = 'Submission';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(2)->schema([
                    TextInput::make('title')
                        ->label('Judul')
                        ->placeholder('Masukkan Judul')
                        ->required()
                        ->maxLength(255),

                    TextInput::make('min_score')
                        ->label('Nilai Minimum')
                        ->placeholder('Masukkan Nilai Minimum')
                        ->numeric()
                        ->required()
                        ->minValue(0)
                        ->maxValue(100),
                ]),

                RichEditor::make('description')
                    ->label('Deskripsi')
                    ->placeholder('Masukkan Deskripsi')
                    ->columnSpanFull()
                    ->required(),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->reorderable('order')
            ->defaultSort('order')
            ->modifyQueryUsing(fn (Builder $query) => $query->whereNotNull('min_score'))
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('order')
                    ->label('Urutan')
                    ->sortable(),
                TextColumn::make('title')
                    ->label('Judul')
                    ->sortable(),
                TextColumn::make('min_score')
                    ->label('Nilai Minimum')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label('Terakhir Diperbarui')
                    ->dateTime()
                    ->sortable(),
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
