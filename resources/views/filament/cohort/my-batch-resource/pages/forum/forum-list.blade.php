<x-filament-panels::page>
    <div class="space-y-6">

        <h2 class="text-2xl font-bold">
            Forum Diskusi Batch {{ $record->name }}
        </h2>

        <div class="flex items-center justify-between gap-4 flex-wrap">

            {{-- KIRI: MODE FILTER --}}
            <div class="flex gap-2">
                <button
                    wire:click="$set('mode', 'all')"
                    style="background: {{ $mode === 'all' ? 'rgb(var(--primary-600))' : 'rgb(var(--primary-50))' }};"
                    class="
                px-4 py-2 rounded-md text-sm font-semibold transition border
                {{ $mode === 'all'
                    ? 'text-white border-orange-600 shadow-sm'
                    : 'text-orange-700 border-orange-200 hover:bg-orange-100'
                }}
            "
                >
                    Semua Pertanyaan
                </button>

                <button
                    wire:click="$set('mode', 'mine')"
                    style="background: {{ $mode === 'mine' ? 'rgb(var(--primary-600))' : 'rgb(var(--primary-50))' }};"
                    class="
                px-4 py-2 rounded-md text-sm font-semibold transition border
                {{ $mode === 'mine'
                    ? 'text-white border-orange-600 shadow-sm'
                    : 'text-orange-700 border-orange-200 hover:bg-orange-100'
                }}
            "
                >
                    Pertanyaan Saya
                </button>
            </div>

            {{-- TENGAH: FILTER TOPIK --}}
            <div class="flex items-center gap-2">
                <span class="text-sm text-gray-500">Topik</span>

                <select
                    wire:model.live="postId"
                    class="rounded-md border-gray-300 text-sm focus:border-orange-500 focus:ring-orange-500"
                >
                    <option value="">Semua</option>

                    @foreach ($record->posts()->orderBy('order')->get() as $post)
                        <option value="{{ $post->id }}">
                            {{ $post->order }}. {{ $post->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- KANAN: SORT --}}
            <button
                wire:click="$set('order', '{{ $order === 'latest' ? 'oldest' : 'latest' }}')"
                class="flex items-center gap-1 text-sm font-medium text-gray-600 hover:text-gray-800 transition"
                title="Ubah urutan"
            >
                @if ($order === 'latest')
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                    Terbaru
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
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
                    class="block"
                >
                    <div class="border rounded-lg p-4 hover:bg-gray-50 transition">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-semibold text-lg">
                                    {{ $thread->title }}
                                </h3>

                                <p class="text-sm text-gray-500">
                                    Topik: {{ $thread->post->title }}
                                </p>
                            </div>

                            <span class="text-xs text-gray-400">
                        {{ $thread->created_at->diffForHumans() }}
                    </span>
                        </div>

                        <p class="mt-2 text-gray-700 line-clamp-2">
                            {{ $thread->content }}
                        </p>

                        <div class="mt-3 text-sm text-gray-500">
                            Oleh {{ $thread->user->name }}
                        </div>
                    </div>
                </a>
            @empty
                <div class="text-center text-gray-500">
                    Belum ada diskusi
                </div>
            @endforelse
        </div>
    </div>
</x-filament-panels::page>
