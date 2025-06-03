<?php

namespace App\Filament\Cohort\Resources\MyBatchResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SubmissionsRelationManager extends RelationManager
{
    protected static string $relationship = 'posts';
    protected static ?string $title = 'Tugas';

    public function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                $query->whereIn('type', ['submission', 'quiz']);
            })
            ->defaultSort('order')
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->sortable(),

                Tables\Columns\TextColumn::make('type')
                    ->label('Jenis')
                    ->formatStateUsing(function (string $state) {
                        return match ($state) {
                            'material' => 'Materi',
                            'submission' => 'Submission',
                            'quiz' => 'Quiz',
                            default => 'Tidak diketahui',
                        };
                    })
                    ->badge(),

                Tables\Columns\TextColumn::make('min_score')
                    ->label('Nilai Minimum')
                    ->placeholder('-'),

                Tables\Columns\TextColumn::make('submissions.file_path')
                    ->label('File Saya')
                    ->formatStateUsing(function ($state) {
                        return $state ? 'Sudah Upload' : 'Belum Upload';
                    }),
            ]);
    }
}
