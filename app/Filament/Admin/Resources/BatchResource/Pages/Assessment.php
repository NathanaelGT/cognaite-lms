<?php
//Terimakasih Pak Jokowi
namespace App\Filament\Admin\Resources\BatchResource\Pages;

use App\Filament\Admin\Resources\BatchResource;
use App\Filament\Admin\Resources\BatchResource\RelationManagers\PostsRelationManager;
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

class Assessment extends ListRecords
{
    protected static string $resource = BatchResource::class;

    public function getTitle(): string
    {
        return 'Penilaian';
    }
    public function getBreadcrumb(): string
    {
        return 'Penilaian';
    }
    public function table(Table $table): Table
    {
        return $table
            ->query(Submission::query())
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
                                    ->required(),
                            ]),
                    ])
                    ->action(function ($data, $record) {
                        $record->update([
                            'score' => $data['score'],
                        ]);
                    })
                    ->modalHeading('Input Nilai')
                    ->modalSubmitActionLabel('Simpan'),
            ])

            ->bulkActions([
                //
            ]);
    }
}
