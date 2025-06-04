<?php

namespace App\Filament\Cohort\Resources\MyBatchResource\Pages;

use App\Filament\Cohort\Resources\MyBatchResource;
use App\Models\Batch;
use App\Models\Post;
use App\Models\QuizResult;
use App\Models\UserPostProgress;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action as FormAction;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\TextEntry\TextEntrySize;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\Page;
use Filament\Support\Enums\FontWeight;
use Illuminate\Support\Facades\Auth;
use App\Traits\ManagesPostNavigation;
use Spatie\Activitylog\Models\Activity as ActivityLog;

class Quiz extends Page
{
    use ManagesPostNavigation;

    protected static string $resource = MyBatchResource::class;
    protected static string $view = 'filament.cohort.my-batch-resource.pages.quiz';

    public ?array $data = [];
    public ?int $score = null;
    public ?bool $passed = null;
    public $hasAttempted = false;
    public $maxScore = 100;

    public function mount(Batch $record, Post $post): void
    {
        $this->commonMount($record, $post);

        $attempt = QuizResult::where('user_id', auth()->id())
            ->where('post_id', $this->post->id)
            ->latest()
            ->first();

        if ($attempt) {
            $this->hasAttempted = true;
            $this->passed = $attempt->passed;
            $this->score = $attempt->score;
            $this->maxScore = $attempt->max_score ?? 100;
        }
    }

    protected function getHeaderActions(): array
    {
        return $this->getCommonHeaderActions();
    }

    public function form(Form $form): Form
    {
        $commonFormNavigationActions = $this->getCommonFormNavigationActions();

        $quizFormActions = [];
        foreach ($commonFormNavigationActions as $action) {
            if (!in_array($action->getName(), ['next', 'finish'])) {
                $quizFormActions[] = $action;
            }
        }

        $quizFormActions[] = FormAction::make('submit')
            ->label('Submit Jawaban')
            ->action('submit')
            ->color('primary');

        return $form
            ->schema([
                Section::make('Pertanyaan')
                    ->schema(
                        $this->post->questions->map(function ($question) {
                            return Radio::make("answers.{$question->id}")
                                ->label($question->content)
                                ->options(
                                    $question->answers->pluck('content', 'id')
                                )
                                ->required();
                        })->toArray()
                    )
                    ->columns(1),

                Actions::make($quizFormActions)->alignBetween(),
            ])
            ->statePath('data');
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

    public function submit(): void
    {
        $userAnswers = $this->data['answers'] ?? [];
        $totalQuestions = $this->post->questions->count();
        $correctAnswers = 0;
        $formattedAnswers = [];

        foreach ($this->post->questions as $question) {
            $userAnswerId = $userAnswers[$question->id] ?? null;
            $isCorrect = false;

            if ($userAnswerId) {
                $answer = $question->answers->find($userAnswerId);
                $isCorrect = $answer ? $answer->is_correct : false;

                if ($isCorrect) {
                    $correctAnswers++;
                }
            }

            $formattedAnswers[] = [
                'question_id' => $question->id,
                'question' => $question->content,
                'answer_id' => $userAnswerId,
                'answer' => $question->answers->find($userAnswerId)?->content ?? 'Tidak dijawab',
                'is_correct' => $isCorrect,
            ];
        }

        $score = $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 100) : 0;
        $passed = $score >= $this->post->min_score;

        $quizResult = QuizResult::create([
            'user_id' => Auth::id(),
            'post_id' => $this->post->id,
            'score' => $score,
            'passed' => $passed,
            'answers' => $formattedAnswers,
        ]);

        activity('quiz')
            ->causedBy(Auth::user())
            ->performedOn($quizResult)
            ->withProperties([
                'score' => $score,
                'quiz_name' => $this->post->title,
            ])
            ->log('Menyelesaikan quiz');

        $this->score = $score;
        $minScore = $this->post->min_score ?? 0;
        $this->passed = $score >= $minScore;
        $this->dispatch('open-modal', id: 'quiz-result', passed: $this->passed, score: $this->score, maxScore: $this->maxScore);

        UserPostProgress::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'post_id' => $this->post->id,
            ],
            [
                'is_completed' => true,
                'is_passed' => $this->passed,
            ]
        );
    }

    public function getFormActions(): array
    {
        $latestQuizResult = QuizResult::where('user_id', Auth::id())
            ->where('post_id', $this->post->id)
            ->latest()
            ->first();

        $passedForFormActions = $this->passed ?? ($latestQuizResult->passed ?? false);
        $hasNextPost = (bool) $this->getNextPost();

        $commonActions = $this->getCommonFormNavigationActions();

        $formActions = [];
        foreach ($commonActions as $action) {
            $formAction = $action;

            if ($action->getName() === 'next') {
                $formAction
                    ->visible($passedForFormActions && $hasNextPost);
            } elseif ($action->getName() === 'finish') {
                $formAction->visible($passedForFormActions && !$hasNextPost);
            }
            $formActions[] = $formAction;
        }

        $formActions[] = FormAction::make('retry')
            ->label('Ulangi Quiz')
            ->icon('heroicon-o-arrow-path')
            ->color('danger')
            ->hidden($passedForFormActions)
            ->action(function () {
                $this->data = [];
                $this->dispatch('close-modal', id: 'quiz-result');
            });

        $formActions[] = FormAction::make('submit')
            ->label('Submit Jawaban')
            ->color('primary')
            ->hidden($passedForFormActions)
            ->action('submit');

        return $formActions;
    }

    protected function getViewData(): array
    {
        return [
            'score' => $this->score,
            'passed' => $this->passed,
            'record' => $this->record,
            'post' => $this->post,
            'hasNextPost' => (bool) $this->getNextPost(),
            'maxScore' => $this->maxScore,
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
