<?php

namespace App\Filament\Cohort\Resources\MyBatchResource\Pages;

use App\Filament\Cohort\Resources\MyBatchResource;
use App\Models\Batch;
use App\Models\ForumThread;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;

class CreateThread extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $resource = MyBatchResource::class;

    protected static string $view ='filament.cohort.my-batch-resource.pages.forum.create-thread';

    public Batch $record;

    public ?array $data = [];

    public function mount(Batch $record): void
    {

        $this->record = $record;
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label('Judul Pertanyaan')
                    ->required()
                    ->maxLength(255),

                Select::make('post_id')
                    ->label('Topik Diskusi')
                    ->options(
                    $this->record->posts()
                        ->orderBy('order')
                        ->get()
                        ->mapWithKeys(fn ($post) => [
                            $post->id => "{$post->order}. {$post->title} (" . ucfirst($post->type) . ")"
                        ])
                        ->toArray()
                    )
                    ->required()
                    ->searchable(),

                Textarea::make('content')
                    ->label('Isi Pertanyaan')
                    ->rows(6)
                    ->required(),
            ])
            ->statePath('data');
    }

    public function submit(): void
    {
        ForumThread::create([
            'batch_id' => $this->record->id,
            'user_id' => Auth::id(),
            'post_id' => $this->data['post_id'],
            'title' => $this->data['title'],
            'content' => $this->data['content'],
        ]);

        $this->redirect(
            MyBatchResource::getUrl('forum', [
                'record' => $this->record->slug,
            ])
        );
    }
}
