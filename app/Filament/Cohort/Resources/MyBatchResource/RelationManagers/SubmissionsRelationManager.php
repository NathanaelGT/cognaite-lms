<?php

namespace App\Filament\Cohort\Resources\MyBatchResource\RelationManagers;

use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubmissionsRelationManager extends RelationManager
{
    protected static string $relationship = 'posts';
    protected static ?string $title = 'Submission';

    public function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                $query->whereNotNull('min_score')
                    ->selectRaw('*, ROW_NUMBER() OVER (ORDER BY `order`) AS `order`');
            })
            ->defaultSort('order')
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('order')
                    ->label('Urutan')
                    ->sortable(),

                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->sortable(),

                Tables\Columns\TextColumn::make('min_score')
                    ->label('Nilai Minimum')
                    ->placeholder('-')
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
