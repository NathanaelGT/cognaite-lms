<?php

namespace App\Filament\Admin\Resources\BatchResource\RelationManagers;

use App\Filament\Admin\Resources\BatchResource\Pages\ViewBatch;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PostsRelationManager extends RelationManager
{
    protected static string $relationship = 'posts';
    protected static ?string $title = 'Postingan';
    protected static bool $isLazy = false;

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
                                    'submission' => 'Submission',
                                    'quiz' => 'Quiz',
                                ])
                                ->default('material')
                                ->searchable()
                                ->required()
                        ]),
                    ]),

                    Forms\Components\Wizard\Step::make('Detail')->schema([
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\TextInput::make('min_score')
                                ->columnSpanFull()
                                ->label('Nilai Minimum')
                                ->placeholder('Masukkan Nilai Minimum')
                                ->numeric()
                                ->visible(fn (Get $get) => in_array($get('type'), ['submission', 'quiz']))
                                ->required()
                                ->minValue(0)
                                ->maxValue(100),

                            Forms\Components\RichEditor::make('description')
                                ->label('Deskripsi')
                                ->placeholder('Masukkan Deskripsi')
                                ->required()
                                ->columnSpanFull(),

                            Forms\Components\RichEditor::make('content')
                                ->label('Konten')
                                ->placeholder('Masukkan Konten')
                                ->required()
                                ->columnSpanFull(),

                            Forms\Components\FileUpload::make('submission_file')
                                ->label('Upload Template Submission')
                                ->visible(fn (Get $get) => $get('type') === 'submission')
                                ->disk('public')
                                ->directory('submissions/templates')
                                ->downloadable()
                                ->openable()
                                ->preserveFilenames()
                                ->required(fn (Get $get) => $get('type') === 'submission')
                                ->columnSpanFull(),

                            Forms\Components\Repeater::make('questions')
                                ->label('Pilihan Ganda')
                                ->visible(fn (Get $get) => $get('type') === 'quiz')
                                ->relationship('questions')
                                ->schema([
                                    Forms\Components\TextInput::make('content')
                                        ->label('Soal')
                                        ->required()
                                        ->columnSpanFull(),

                                    Forms\Components\Repeater::make('answers')
                                        ->label('Pilihan Jawaban')
                                        ->relationship('answers')
                                        ->schema([
                                            Forms\Components\TextInput::make('content')
                                                ->label('Jawaban')
                                                ->required(),

                                            Forms\Components\Radio::make('is_correct')
                                                ->label('Apakah ini jawaban benar?')
                                                ->boolean()
                                                ->default(false),
                                        ])
                                        ->minItems(2)
                                        ->columns(2)
                                        ->required(),
                                ])
                                ->grid(1)
                                ->columnSpanFull()
                                ->itemLabel(fn (array $state): ?string => $state['question'] ?? null)
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
            ->modifyQueryUsing(function (Builder $query, PostsRelationManager $livewire) {
                if ($livewire->pageClass === ViewBatch::class) {
                    $query->whereIn('type', ['submission']);
                }
            })
            ->columns([
                Tables\Columns\TextColumn::make('order')
                    ->label('Urutan')
                    ->sortable(),

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
                Tables\Actions\CreateAction::make()
                    ->after(function (Post $record, array $data) {
                        if ($record->type === 'quiz' && isset($data['questions'])) {
                            foreach ($data['questions'] as $questionData) {
                                $answers = $questionData['answers'] ?? [];
                                unset($questionData['answers']);

                                $question = $record->questions()->create($questionData);
                                $question->answers()->createMany($answers);
                            }
                        }
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->after(function (Post $record, array $data) {
                        if ($record->type === 'quiz') {

                            foreach ($data['questions'] ?? [] as $questionData) {
                                $answers = $questionData['answers'] ?? [];
                                unset($questionData['answers']);

                                $question = $record->questions()->create($questionData);
                                $question->answers()->createMany($answers);
                            }
                        }
                    }),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
