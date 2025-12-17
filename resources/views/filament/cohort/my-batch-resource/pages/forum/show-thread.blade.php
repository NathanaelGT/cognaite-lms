<x-filament-panels::page>
    <div class="space-y-4">

        {{-- Header --}}
        <div class="flex justify-between items-start gap-4">
            <div>
                <h2 class="text-xl font-bold">
                    {{ $thread->title }}
                </h2>

                <p class="text-sm text-gray-500">
                    Topik: {{ $thread->post->title }}
                </p>
            </div>
        </div>

        {{-- Filter Urutan --}}
        <div class="flex justify-end items-center text-sm text-gray-500 gap-2">

            <button
                wire:click="$set('order', '{{ $order === 'latest' ? 'oldest' : 'latest' }}')"
                class="flex items-center gap-1 hover:text-gray-700 transition"
                title="Ubah urutan balasan"
            >
                @if ($order === 'latest')
                    {{-- terbaru --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                    <span>Terbaru</span>
                @else
                    {{-- terlama --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
                    </svg>
                    <span>Terlama</span>
                @endif
            </button>
        </div>

        {{-- Replies --}}
        <div class="space-y-3 mt-3">
            @foreach ($this->getReplies() as $reply)
                <div class="p-3 rounded-lg border bg-white">
                    <div class="text-sm font-semibold">
                        {{ $reply->user->name }}
                    </div>

                    <div class="text-gray-700 mt-1">
                        {{ $reply->content }}
                    </div>

                    <div class="text-xs text-gray-400 mt-1">
                        {{ $reply->created_at->diffForHumans() }}
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Form Reply --}}
        <form wire:submit.prevent="send" class="mt-4 space-y-2">
            <textarea
                wire:model.defer="message"
                class="w-full border rounded-md p-2"
                rows="3"
                placeholder="Tulis balasan..."
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
