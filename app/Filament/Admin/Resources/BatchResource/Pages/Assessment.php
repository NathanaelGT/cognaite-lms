<?php
namespace App\Filament\Admin\Resources\BatchResource\Pages;

use App\Filament\Admin\Resources\BatchResource;
use App\Filament\Admin\Resources\BatchResource\RelationManagers\PostsRelationManager;
use App\Filament\Cohort\Resources\MyBatchResource;
use App\Models\UserPostProgress;
use Filament\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Submission;
use Filament\Tables\Actions\Action;
use App\Models\Batch;

class Assessment extends ListRecords
{
    protected static string $resource = BatchResource::class;

    public Batch $record;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('back')
                ->label('Kembali')
                ->url(fn () => BatchResource::getUrl('view', [$this->record])),

        ];
    }
    public ?int $assessment = null;

    public function getTitle(): string
    {
        return 'Penilaian';
    }

    public function getPostTitle(): string
    {
        return \App\Models\Post::find($this->assessment)?->title;
    }

    public function getBreadcrumb(): string
    {
        return 'Penilaian';
    }
    public function table(Table $table): Table
    {
        return $table
            ->heading($this->getPostTitle())
            ->query(fn () => Submission::query()->where('post_id', $this->assessment))
            ->columns([
                TextColumn::make('user.name')
                ->label('Nama User')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('file_path')
                    ->label('File')
                    ->url(fn ($record) => asset('storage/' . $record->file_path))
                    ->formatStateUsing(fn ($state) => basename($state))
                    ->openUrlInNewTab()
                    ->limit(50),

                TextColumn::make('notes')
                    ->label('Catatan')
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->notes),

                TextColumn::make('score')
                    ->label('Nilai')
                    ->default('Belum dinilai')
                    ->badge(),

                TextColumn::make('created_at')
                    ->label('Dikirim Pada')
                    ->dateTime('j F Y \P\u\k\u\l H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('score')
                    ->label('Nilai')
                    ->icon('heroicon-m-pencil-square')
                    ->mountUsing(fn ($form, $record) => $form->fill([
                        'user_name' => $record->user->name,
                        'notes' => $record->notes,
                        'score' => $record->score,
                        'file_path' => $record->file_path,
                    ]))
                    ->form([
                        \Filament\Forms\Components\Section::make('Detail Submission')
                            ->schema([
                                \Filament\Forms\Components\TextInput::make('user_name')
                                    ->label(fn($record) => 'Nama User')
                                    ->disabled(),

                                \Filament\Forms\Components\ViewField::make('file_path')
                                    ->view('filament.forms.components.file-preview'),

                                \Filament\Forms\Components\Textarea::make('notes')
                                    ->label('Catatan')
                                    ->disabled(),

                                \Filament\Forms\Components\TextInput::make('score')
                                    ->label('Nilai')
                                    ->numeric()
                                    ->minValue(0)
                                    ->maxValue(100)
                                    ->placeholder('Masukkan Nilai (0-100)')
                                    ->required(),
                            ]),
                    ])
                    ->action(function ($data, $record) {
                        $record->update([
                            'score' => $data['score'],
                        ]);

                        $minScore = $record->post->min_score;

                        if ($data['score'] >= $minScore) {
                            UserPostProgress::updateOrCreate(
                                [
                                    'user_id' => $record->user_id,
                                    'post_id' => $record->post_id,
                                ],
                                [
                                    'is_passed' => true,
                                    'is_completed' => true,
                                ]
                            );
                        } else {
                            UserPostProgress::updateOrCreate(
                                [
                                    'user_id' => $record->user_id,
                                    'post_id' => $record->post_id,
                                ],
                                [
                                    'is_passed' => false,
                                    'is_completed' => true,
                                ]
                            );
                        }
                    })
                    ->modalHeading('Input Nilai')
                    ->modalSubmitActionLabel('Simpan'),
            ])

            ->bulkActions([
                //
            ]);
    }
}
