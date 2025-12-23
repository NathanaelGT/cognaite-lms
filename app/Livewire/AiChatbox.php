<?php

namespace App\Livewire;

use App\Models\AiChat;
use App\Models\Batch;
use Cloudstudio\Ollama\Facades\Ollama;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Component;

class AiChatbox extends Component
{
    #[Locked]
    public int $batchId;

    public string $currentPrompt = '';

    public string $prompt = '';

    public string $answer = '';

    function submitPrompt(): void
    {
        $encodedPrompt = json_encode($this->prompt);

        $this->currentPrompt = $this->prompt;
        $this->answer = '';
        $this->prompt = '';

        $this->js("\$wire.ask({$encodedPrompt})");
    }

    function ask(string $prompt): void
    {
        $batch = Batch::findOrFail($this->batchId);
        $posts = Auth::user()->postProgress()
            ->whereIn('post_id', $batch->posts()->pluck('id'))
            ->get();

        $messages = [
            ['role' => 'system', 'content' => 'Anda adalah asisten AI pembelajaran untuk Cognaite Academy yang bernama Cogi.'],
            ['role' => 'system', 'content' => "Saat ini pengguna sedang mempelajari tentang $batch->name."],
            ['role' => 'system', 'content' => 'Jika pengguna bertanya diluar materi, jawab dengan sopan bahwa Anda hanya dapat membantu dalam konteks materi pembelajaran ini.'],
        ];

        foreach ($posts as $index => $post) {
            $no = $index + 1;
            $messages[] = ['role' => 'system', 'content' => "Materi {$no}: {$post->post->title}\nIsi: {$post->post->content}"];
        }

        foreach ($this->history as $history) {
            $messages[] = [
                'role' => $history->from_user ? 'user' : 'assistant',
                'content' => $history->message,
            ];
        }

        $messages[] = ['role' => 'user', 'content' => $prompt];

        $response = Ollama::model('gemma3:4b')
            ->options(['temperature' => 0.3])
            ->stream(true)
            ->chat($messages);

        $answer = '';
        Ollama::processStream($response->getBody(), function ($data) use (&$answer) {
            $this->stream(to: 'answer', content: Str::markdown($answer .= $data['message']['content']), replace: true);
        });

        AiChat::create([
            'user_id' => Auth::id(),
            'batch_id' => $this->batchId,
            'from_user' => true,
            'message' => $this->currentPrompt,
        ]);

        AiChat::create([
            'user_id' => Auth::id(),
            'batch_id' => $this->batchId,
            'from_user' => false,
            'message' => $answer,
        ]);

        $this->answer = Str::markdown($answer);
    }

    #[Computed]
    protected function history(): Collection
    {
        return AiChat::query()
            ->where('user_id', Auth::id())
            ->where('batch_id', $this->batchId)
            ->get();
    }
}
