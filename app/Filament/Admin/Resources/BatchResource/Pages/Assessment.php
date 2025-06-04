<?php

namespace App\Filament\Admin\Resources\BatchResource\Pages;

use App\Filament\Admin\Resources\BatchResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Submission;

class Assessment extends ListRecords
{
    protected static string $resource = BatchResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->query(Submission::query())
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                TextColumn::make('post_id')
                    ->label('Post ID')
                    ->sortable(),

                TextColumn::make('user_id')
                    ->label('User ID')
                    ->sortable(),

                TextColumn::make('file_path')
                    ->label('File')
                    ->url(fn ($record) => asset('storage/' . $record->file_path))
                    ->openUrlInNewTab()
                    ->limit(30), // jika ingin tampil ringkas

                TextColumn::make('notes')
                    ->label('Catatan')
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->notes),

                TextColumn::make('score')
                    ->label('Skor')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Dikirim Pada')
                    ->dateTime('j F Y \P\u\k\u\l H:i')
                    ->sortable(),

                TextColumn::make('updated_at')
                    ->label('Diperbarui')
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
}
