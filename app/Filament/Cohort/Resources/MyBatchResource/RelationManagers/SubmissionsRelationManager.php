<?php

namespace App\Filament\Cohort\Resources\MyBatchResource\RelationManagers;

use App\Models\Submission;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Get;

class SubmissionsRelationManager extends RelationManager
{
    protected static string $relationship = 'posts';
    protected static ?string $title = 'Tugas';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Group::make([
                Forms\Components\Placeholder::make('template')
                    ->label('Template Submission')
                    ->content(function ($record) {
                        if ($record->type === 'submission' && $record->submission_file) {
                            $url = asset('storage/' . $record->submission_file);
                            return "<a href='{$url}' target='_blank' class='text-primary underline'>Download Template</a>";
                        }
                        return 'Tidak ada template.';
                    })
                    ->visible(fn (Get $get) => $get('type') === 'submission')
                    ->columnSpanFull()
                    ->disableLabel(),

                Forms\Components\FileUpload::make('submission_file')
                    ->label('Unggah File Kamu')
                    ->disk('public')
                    ->directory('submissions/user-files')
                    ->visible(fn (Get $get) => $get('type') === 'submission')
                    ->preserveFilenames()
                    ->required()
                    ->columnSpanFull(),
            ])->columnSpanFull(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                $query->where('type', 'submission')
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

                Tables\Columns\TextColumn::make('submissions.file_path')
                    ->label('File Saya')
                    ->formatStateUsing(function ($state) {
                        return $state ? 'Sudah Upload' : 'Belum Upload';
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('Upload File')
                    ->form([
                        Forms\Components\FileUpload::make('file_path')
                            ->label('Unggah File Submission')
                            ->disk('public')
                            ->directory('submissions/user-files')
                            ->preserveFilenames()
                            ->required(),
                    ])
                    ->action(function ($record, array $data) {
                        Submission::updateOrCreate(
                            [
                                'post_id' => $record->id,
                                'user_id' => Auth::id(),
                            ],
                            [
                                'file_path' => $data['file_path'],
                            ]
                        );
                    })
                    ->visible(fn ($record) => $record->type === 'submission'),
            ]);
    }
}
