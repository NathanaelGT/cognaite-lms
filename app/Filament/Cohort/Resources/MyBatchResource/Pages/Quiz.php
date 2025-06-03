<?php

namespace App\Filament\Cohort\Resources\MyBatchResource\Pages;

use App\Filament\Cohort\Resources\MyBatchResource;
use App\Models\Batch;
use App\Models\Post;
use App\Models\QuizResult;
use App\Models\UserPostProgress;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action as FormAction;
use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\TextEntry\TextEntrySize;
use Filament\Resources\Pages\Page;
use Filament\Support\Enums\FontWeight;
use Filament\Infolists\Infolist;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Auth;

class Quiz extends Page
{
    protected static string $resource = MyBatchResource::class;
    protected static string $view = 'filament.cohort.my-batch-resource.pages.quiz';

    public Post $post;
    public Batch $record;
    public ?array $data = [];
    public ?int $score = null;
    public ?bool $passed = null;


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

    public function mount(Batch $record, Post $post): void
    {
        $this->record = $record;
        $this->post = $post;
    }

    public function form(Form $form): Form
    {
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

                Actions::make([
                    FormAction::make('previous')
                        ->label('Sebelumnya')
                        ->icon('heroicon-o-arrow-left')
                        ->url(function () {
                            $prevPost = $this->getPreviousPost();
                            if (!$prevPost) return null;

                            return $prevPost->type === 'quiz'
                                ? MyBatchResource::getUrl('quiz', [
                                    'record' => $this->record->slug,
                                    'post' => $prevPost->slug,
                                ])
                                : MyBatchResource::getUrl('learn-material', [
                                    'record' => $this->record->slug,
                                    'post' => $prevPost->slug,
                                ]);
                        })
                        ->disabled(fn () => !$this->getPreviousPost())
                        ->color('primary'),

                    FormAction::make('submit')
                        ->label('Submit Jawaban')
                        ->action('submit')
                        ->color('primary'),
                ])->alignBetween(),
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
                'is_correct' => $isCorrect
            ];
        }

        $score = $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 100) : 0;
        $passed = $score >= $this->post->min_score;

        QuizResult::create([
            'user_id' => Auth::id(),
            'post_id' => $this->post->id,
            'score' => $score,
            'passed' => $passed,
            'answers' => $formattedAnswers
        ]);

        $this->score = $score;
        $minScore = $this->post->min_score ?? 0;
        $this->passed = $score >= $minScore;
        $this->dispatch('open-modal', id: 'quiz-result');

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

        return [
            FormAction::make('previous')
                ->label('Sebelumnya')
                ->icon('heroicon-o-arrow-left')
                ->url(function () {
                    $prevPost = $this->getPreviousPost();
                    if (!$prevPost) return null;

                    return $prevPost->type === 'quiz'
                        ? MyBatchResource::getUrl('quiz', [
                            'record' => $this->record->slug,
                            'post' => $prevPost->slug,
                        ])
                        : MyBatchResource::getUrl('learn-material', [
                            'record' => $this->record->slug,
                            'post' => $prevPost->slug,
                        ]);
                })
                ->disabled(fn () => !$this->getPreviousPost())
                ->color('primary'),

            FormAction::make('retry')
                ->label('Ulangi Quiz')
                ->icon('heroicon-o-arrow-path')
                ->color('danger')
                ->hidden($passedForFormActions)
                ->action(function () {
                    $this->data = [];
                    $this->dispatch('close-modal', id: 'quiz-result');
                }),

            FormAction::make('next')
                ->label('Lanjutkan')
                ->icon('heroicon-o-arrow-right')
                ->color('success')
                ->visible($passedForFormActions && $hasNextPost)
                ->url(function () {
                    $nextPost = $this->getNextPost();
                    if (!$nextPost) {
                        return MyBatchResource::getUrl('view', [
                            'record' => $this->record->slug
                        ]);
                    }

                    return $nextPost->type === 'quiz'
                        ? MyBatchResource::getUrl('quiz', [
                            'record' => $this->record->slug,
                            'post' => $nextPost->slug,
                        ])
                        : MyBatchResource::getUrl('learn-material', [
                            'record' => $this->record->slug,
                            'post' => $nextPost->slug,
                        ]);
                }),

            FormAction::make('finish')
                ->label('Selesai')
                ->icon('heroicon-o-check')
                ->url(MyBatchResource::getUrl('view', [
                    'record' => $this->record->slug
                ]))
                ->color('success')
                ->visible($passedForFormActions && !$hasNextPost),

            FormAction::make('submit')
                ->label('Submit Jawaban')
                ->color('primary')
                ->hidden($passedForFormActions)
                ->action('submit'),
        ];
    }

    protected function getPreviousPost(): ?Post
    {
        return $this->record->posts()
            ->where('order', '<', $this->post->order)
            ->orderBy('order', 'desc')
            ->first();
    }

    protected function getNextPost(): ?Post
    {
        return $this->record->posts()
            ->where('order', '>', $this->post->order)
            ->orderBy('order', 'asc')
            ->first();
    }

    protected function getViewData(): array
    {
        return [
            'score' => $this->score,
            'passed' => $this->passed,
            'record' => $this->record,
            'post' => $this->post,
            'hasNextPost' => (bool) $this->getNextPost(),
        ];
    }
}
