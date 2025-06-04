<?php

namespace App\Filament\Cohort\Resources\MyBatchResource\Pages;

use App\Filament\Cohort\Resources\MyBatchResource;
use App\Models\Batch;
use App\Models\Post;
use App\Models\Submission;
use App\Models\UserPostProgress;
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
use Filament\Resources\Pages\Page;
use Filament\Support\Enums\FontWeight;
use Illuminate\Support\Facades\Auth;
use App\Traits\ManagesPostNavigation;
use Spatie\Activitylog\Models\Activity as ActivityLog;

class SubmissionPage extends Page implements HasForms
{
    use InteractsWithForms;
    use ManagesPostNavigation;

    protected static string $resource = MyBatchResource::class;
    protected static string $view = 'filament.cohort.my-batch-resource.pages.submission-page';

    public ?array $data = [];
    public $hasSubmitted = false;
    public $submissionStatus = null;
    public $submissionScore = null;
    public $isPassed = false;
    public $showResultModal = false;

    public function mount(Batch $record, Post $post): void
    {
        $this->commonMount($record, $post);

        $submission = Submission::where('post_id', $this->post->id)
            ->where('user_id', Auth::id())
            ->latest()
            ->first();

        if ($submission) {
            $this->hasSubmitted = true;
            $this->submissionStatus = $submission->status;
            $this->submissionScore = $submission->score;
            $this->isPassed = !is_null($submission->score) && $submission->score >= $this->post->min_score;
            $this->showResultModal = !is_null($submission->score);
            $this->data = [
                'file_path' => $submission->file_path,
                'notes' => $submission->notes,
            ];
        }

        $this->form->fill();
    }

    protected function getHeaderActions(): array
    {
        return $this->getCommonHeaderActions();
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
        $commonFormNavigationActions = $this->getCommonFormNavigationActions();

        $submissionFormActions = array_filter($commonFormNavigationActions, function($action) {
            return !in_array($action->getName(), ['next', 'finish']);
        });

        $submissionFormActions[] = FormAction::make('submit')
            ->label('Kirim Tugas')
            ->action('submit')
            ->color('primary');

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

                Actions::make($submissionFormActions)->alignBetween(),
            ])
            ->statePath('data');
    }

    public function submit(): void
    {
        $data = $this->form->getState();
        $user = Auth::user();

        $fileName = basename($data['file_path']);

        $submission = Submission::updateOrCreate(
            [
                'post_id' => $this->post->id,
                'user_id' => $user->id,
            ],
            [
                'file_path' => $data['file_path'],
                'notes' => $data['notes'] ?? null,
                'score' => null,
            ]
        );

        activity('submission')
            ->causedBy($user)
            ->performedOn($submission)
            ->withProperties([
                'file_name' => $fileName,
                'post_name' => $this->post->title,
            ])
            ->log('Mengirim file submission');

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

    public function resubmit(): void
    {
        $this->showResultModal = false;
        $this->hasSubmitted = false;
        $this->submissionScore = null;
        $this->isPassed = false;
        $this->data = [
            'file_path' => null,
            'notes' => null,
        ];
    }

    public function completeBatchFromModal(): void
    {
        $user = Auth::user();
        $batchName = $this->record->name;

        $existingLog = ActivityLog::where('log_name', 'batch')
            ->where('description', 'Menyelesaikan batch')
            ->where('causer_id', $user->id)
            ->whereJsonContains('properties->batch_name', $batchName)
            ->first();

        if (!$existingLog) {
            activity('batch')
                ->causedBy($user)
                ->withProperties([
                    'batch_name' => $batchName,
                ])
                ->log('Menyelesaikan batch');
        }

        redirect()->to(MyBatchResource::getUrl('view', [
            'record' => $this->record->slug,
        ]));
    }
}
