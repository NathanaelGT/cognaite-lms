<?php

namespace App\Filament\Cohort\Resources\BatchResource\RelationManagers;

use App\Models\Post;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;

class PostsRelationManager extends RelationManager
{
    protected static string $relationship = 'posts';

    protected static ?string $title = 'Silabus';

    protected static bool $isLazy = false;

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->paginated(false)
            ->modifyQueryUsing(fn (Builder $query) => $query->orderBy('order'))
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('')
                    ->description(fn(Post $record) => new HtmlString($record->description))
                    ->size(TextColumnSize::Large)
                    ->weight(FontWeight::Bold),
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
