<x-filament::page>
    <h2 class="text-2xl font-bold mb-4">Batch Saya</h2>

    @forelse ($batches as $batch)
        <div class="p-4 bg-white border rounded-xl shadow space-y-2 mb-4">
            @if ($batch->thumbnail)
                <img src="{{ asset('storage/' . $batch->thumbnail) }}" alt="Thumbnail" class="w-32 h-20 object-cover rounded shadow">
            @endif

            <div class="flex justify-between mt-2">
                <div>
                    <h3 class="text-lg font-semibold">{{ $batch->name }}</h3>
                    <p class="text-sm text-gray-600">{{ $batch->description }}</p>
                </div>
                <div class="flex gap-2 items-start">
                    <x-filament::button color="gray" wire:click="showDetail({{ $batch->id }})">
                        Detail
                    </x-filament::button>
                    <x-filament::button color="danger" wire:click="dropBatch({{ $batch->id }})">
                        Keluar
                    </x-filament::button>
                </div>
            </div>

            @if ($detailBatchId === $batch->id)
                <div class="mt-3 border-t pt-3 text-sm">
                    <h4 class="font-medium">Materi dalam batch:</h4>
                    <ul class="list-disc list-inside">
                        @forelse ($batch->posts as $post)
                            <li>{{ $post->title }}</li>
                        @empty
                            <li>Tidak ada materi.</li>
                        @endforelse
                    </ul>
                </div>
            @endif
        </div>
    @empty
        <p>Kamu belum bergabung ke batch manapun.</p>
    @endforelse
</x-filament::page>
