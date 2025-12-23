<x-filament-panels::page>
    <div class="space-y-6">

        <h2 class="text-2xl font-bold">
            Forum Diskusi Batch {{ $record->name }}
        </h2>

        <div class="flex items-center gap-4 text-sm flex-wrap">
            <div class="flex items-center gap-2">
                <span class="text-gray-500">Tampilkan</span>
                <div
                    style="border: 1px solid #fed7aa; border-radius: 0.375rem; overflow: hidden; display: flex;"
                >
                    <button
                        wire:click="$set('mode', 'all')"
                        style="
                            padding: 0.375rem 0.75rem;
                            font-weight: 600;
                            background: {{ $mode === 'all' ? 'rgb(217 119 6)' : 'rgb(255 247 237)' }};
                            color: {{ $mode === 'all' ? '#ffffff' : 'rgb(180 83 9)' }};
                        "
                    >
                        Semua
                    </button>

                    <button
                        wire:click="$set('mode', 'mine')"
                        style="
                            padding: 0.375rem 0.75rem;
                            font-weight: 600;
                            background: {{ $mode === 'mine' ? 'rgb(217 119 6)' : 'rgb(255 247 237)' }};
                            color: {{ $mode === 'mine' ? '#ffffff' : 'rgb(180 83 9)' }};
                        "
                    >
                        Saya
                    </button>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <span class="text-gray-500">Topik</span>

                <select
                    wire:model.live="postId"
                    style="
                        border-radius: 0.375rem;
                        border: 1px solid #d1d5db;
                        padding: 0.375rem 0.5rem;
                        font-size: 0.875rem;
                    "
                >
                    <option value="">Semua</option>

                    @foreach (
                        $record->posts()
                            ->get()
                            ->filter(fn ($post) => auth()->user()->canAccessPost($post))
                            ->sortBy('order')
                            as $post
                    )
                    <option value="{{ $post->id }}">
                            {{ $post->order }}. {{ $post->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button
                wire:click="$set('order', '{{ $order === 'latest' ? 'oldest' : 'latest' }}')"
                style="display: flex; align-items: center; gap: 0.25rem; font-weight: 500; color: #4b5563;"
            >
                @if ($order === 'latest')
                    <svg xmlns="http://www.w3.org/2000/svg" style="width: 1rem; height: 1rem;" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                    Terbaru
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" style="width: 1rem; height: 1rem;" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"/>
                    </svg>
                    Terlama
                @endif
            </button>
        </div>

        <div class="space-y-4">
            @forelse($this->getThreads() as $thread)
                <a
                    href="{{ \App\Filament\Cohort\Resources\MyBatchResource::getUrl('show-thread', [
                        'record' => $record->slug,
                        'thread' => $thread->id,
                    ]) }}"
                    style="display: block;"
                >
                    <div style="border: 1px solid #e5e7eb; border-radius: 0.5rem; padding: 1rem;">
                        <div style="display: flex; justify-content: space-between;">
                            <div>
                                <h3 style="font-weight: 600; font-size: 1.125rem;">
                                    {{ $thread->title }}
                                </h3>

                                <p style="font-size: 0.875rem; color: #6b7280;">
                                    Topik: {{ $thread->post->title }}
                                </p>
                            </div>

                            <span style="font-size: 0.75rem; color: #9ca3af;">
                                {{ $thread->created_at->diffForHumans() }}
                            </span>
                        </div>

                        <p style="margin-top: 0.5rem; color: #374151;">
                            {{ $thread->content }}
                        </p>

                        <div style="margin-top: 0.75rem; font-size: 0.875rem; color: #6b7280;">
                            Oleh {{ $thread->user->name }}
                        </div>
                    </div>
                </a>
            @empty
                <div style="text-align: center; color: #6b7280;">
                    Belum ada diskusi
                </div>
            @endforelse
        </div>
    </div>
</x-filament-panels::page>
