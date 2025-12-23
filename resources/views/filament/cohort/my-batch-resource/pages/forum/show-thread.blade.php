<x-filament-panels::page>
    <div class="space-y-6">

        {{-- THREAD UTAMA --}}
        <div class="border rounded-lg bg-white p-4">
            <h2 class="text-xl font-bold">
                {{ $thread->title }}
            </h2>

            <div class="text-sm text-gray-500 mt-1">
                Topik: {{ $thread->post->title }}
            </div>

            <div class="mt-3 text-sm text-gray-600">
                Oleh <span class="font-medium text-gray-800">{{ $thread->user->name }}</span>
                • {{ $thread->created_at->diffForHumans() }}
            </div>

            <div class="mt-4 text-gray-800 whitespace-pre-line">
                {{ $thread->content }}
            </div>
        </div>

        {{-- FILTER URUTAN --}}
        <div class="flex justify-end items-center text-sm text-gray-500 gap-2">
            <button
                wire:click="$set('order', '{{ $order === 'latest' ? 'oldest' : 'latest' }}')"
                class="flex items-center gap-1 hover:text-gray-700 transition"
            >
                @if ($order === 'latest')
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                    Terbaru
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
                    </svg>
                    Terlama
                @endif
            </button>
        </div>

        {{-- BALASAN --}}
        <div class="space-y-3">
            @forelse ($this->getReplies() as $reply)
                <div class="p-3 rounded-lg border bg-gray-50">
                    <div class="text-sm font-semibold">
                        {{ $reply->user->name }}
                    </div>

                    <div class="text-gray-700 mt-1 whitespace-pre-line">
                        {{ $reply->content }}
                    </div>

                    <div class="text-xs text-gray-400 mt-1">
                        {{ $reply->created_at->diffForHumans() }}
                    </div>
                </div>
            @empty
                <div class="text-sm text-gray-500 text-center">
                    Belum ada balasan
                </div>
            @endforelse
        </div>

        {{-- FORM BALAS --}}
        <form wire:submit.prevent="send" class="space-y-2">
            <textarea
                wire:model.defer="message"
                rows="3"
                placeholder="Tulis balasan..."
                class="w-full border rounded-md p-2"
                required
            ></textarea>

            <div class="flex justify-end">
                <x-filament::button type="submit">
                    Kirim
                </x-filament::button>
            </div>
        </form>

    </div>
</x-filament-panels::page>
