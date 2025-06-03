<?php

namespace App\Filament\Cohort\Resources\MyBatchResource\Pages;

use App\Filament\Cohort\Resources\MyBatchResource;
use App\Models\Batch;
use App\Models\Post;
use App\Models\Submission;
use App\Models\UserPostProgress;
use Filament\Actions\Action;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action as FormAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\TextEntry\TextEntrySize;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Filament\Support\Enums\FontWeight;
use Illuminate\Support\Facades\Auth;

class SubmissionPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $resource = MyBatchResource::class;
    protected static string $view = 'filament.cohort.my-batch-resource.pages.submission-page';

    public Post $post;
    public Batch $record;
    public ?array $data = [];
    public $hasSubmitted = false;
    public $submissionStatus = null;

    public function mount(Batch $record, Post $post): void
    {
        $this->record = $record;
        $this->post = $post;

        $submission = Submission::where('post_id', $this->post->id)
            ->where('user_id', Auth::id())
            ->latest()
            ->first();

        if ($submission) {
            $this->hasSubmitted = true;
            $this->submissionStatus = $submission->status;
        }

        $this->form->fill();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Kembali')
                ->icon('heroicon-o-arrow-long-left')
                ->url(fn () => MyBatchResource::getUrl('view', [
                    'record' => $this->record->slug,
                ])),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->record($this->post)
            ->schema([
                TextEntry::make('title')
                    ->columnSpanFull()
                    ->hiddenLabel()
                    ->weight(FontWeight::Bold)
                    ->size(TextEntrySize::Large),

                TextEntry::make('description')
                    ->hiddenLabel()
                    ->columnSpanFull()
                    ->size(TextEntrySize::Large)
                    ->markdown(),
            ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Upload Tugas')
                    ->schema([
                        FileUpload::make('file_path')
                            ->label('File Submission')
                            ->disk('public')
                            ->directory('submissions/user-files')
                            ->preserveFilenames()
                            ->required(),

                        Textarea::make('notes')
                            ->label('Catatan Tambahan (opsional)')
                            ->rows(4)
                            ->maxLength(500)
                            ->placeholder('Tambahkan catatan untuk mentor')
                            ->nullable(),
                    ])
                    ->columns(1),

                Actions::make([
                    FormAction::make('previous')
                        ->label('Sebelumnya')
                        ->icon('heroicon-o-arrow-left')
                        ->url(function () {
                            $prevPost = $this->getPreviousPost();
                            if (! $prevPost) {
                                return null;
                            }

                            return match ($prevPost->type) {
                                'quiz' => MyBatchResource::getUrl('quiz', [
                                    'record' => $this->record->slug,
                                    'post' => $prevPost->slug,
                                ]),
                                'submission' => MyBatchResource::getUrl('submission', [
                                    'record' => $this->record->slug,
                                    'post' => $prevPost->slug,
                                ]),
                                default => MyBatchResource::getUrl('learn-material', [
                                    'record' => $this->record->slug,
                                    'post' => $prevPost->slug,
                                ]),
                            };
                        })
                        ->disabled(fn () => ! $this->getPreviousPost())
                        ->color('primary'),

                    FormAction::make('submit')
                        ->label('Kirim Tugas')
                        ->action('submit')
                        ->color('primary'),
                ])->alignBetween(),
            ])
            ->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [
            Actions\Action::make('submit')
                ->label('Kirim Submission')
                ->submit('submit'),
        ];
    }

    public function submit(): void
    {
        $data = $this->form->getState();

        Submission::updateOrCreate(
            [
                'post_id' => $this->post->id,
                'user_id' => Auth::id(),
            ],
            [
                'file_path' => $data['file_path'],
                'notes' => $data['notes'] ?? null,
            ]
        );

        UserPostProgress::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'post_id' => $this->post->id,
            ],
            [
                'is_completed' => true,
                'is_passed' => false,
            ]
        );

        $this->dispatch('submission-success');
    }

    protected function getPreviousPost(): ?Post
    {
        return $this->record->posts()
            ->where('order', '<', $this->post->order)
            ->orderBy('order', 'desc')
            ->first();
    }
}
