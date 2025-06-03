<?php

namespace App\Filament\Cohort\Resources\MyBatchResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class SubmissionsRelationManager extends RelationManager
{
    protected static string $relationship = 'posts';
    protected static ?string $title = 'Tugas';

    public function table(Table $table): Table
    {
        $userId = Auth::id();

        return $table
            ->modifyQueryUsing(function (Builder $query) use ($userId) {
                $query->whereIn('type', ['submission', 'quiz'])
                    ->with([
                        'quizResults' => fn ($query) => $query->where('user_id', $userId),
                        'submissions' => fn ($query) => $query->where('user_id', $userId)
                    ]);
            })
            ->defaultSort('order')
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul'),

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

                Tables\Columns\TextColumn::make('user_score')
                    ->label('Nilai')
                    ->state(function ($record) use ($userId) {
                        if ($record->type === 'quiz') {
                            $quizResult = $record->quizResults()
                            ->where('user_id', $userId)
                            ->latest()
                            ->first();
                            return $quizResult ? ($quizResult->score ?? 'Belum dinilai') : '-';
                        }

                        if ($record->type === 'submission') {
                            $submission = $record->submissions()
                            ->where('user_id', $userId)
                            ->latest()
                            ->first();
                            return $submission ? ($submission->score ?? 'Sedang dinilai') : '-';
                        }

                        return '-';
                    })
                    ->color(function ($state) {
                        if (is_numeric($state)) {
                            return 'success';
                        } elseif ($state === 'Sedang dinilai') {
                            return 'warning';
                        }
                        return 'gray';
                    }),
            ]);
    }
}
