<x-filament::page>
    <h2 class="text-2xl font-bold mb-6">Batch Tersedia</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($this->batches as $batch)
            <div class="bg-white rounded-xl shadow p-4">
                {{-- Thumbnail --}}
                <img
                    src="{{ $batch->thumbnail ? asset('storage/' . $batch->thumbnail) : asset('images/default-thumbnail.jpg') }}"
                    alt="{{ $batch->name }}"
                    class="w-32 h-20 object-cover rounded shadow"
                >

                {{-- Info --}}
                <h3 class="text-lg font-semibold">{{ $batch->name }}</h3>
                <p class="text-sm text-gray-600 mb-2">{{ \Illuminate\Support\Str::limit(strip_tags($batch->description), 80) }}</p>
                <p class="text-sm text-gray-700">
                    Harga: <strong>{{ $batch->price ? 'Rp ' . number_format($batch->price, 0, ',', '.') : 'Gratis' }}</strong>
                </p>
                <p class="text-sm text-gray-700 mb-3">
                    Durasi: {{ $batch->duration }} menit
                </p>

                {{-- Tombol Ambil / Sudah Diambil --}}
                @if (in_array($batch->id, $this->joinedBatchIds))
                    <x-filament::button color="gray" disabled>
                        Sudah Diambil
                    </x-filament::button>
                @else
                    <x-filament::button wire:click="joinBatch({{ $batch->id }})" color="primary">
                        Ambil Batch
                    </x-filament::button>
                @endif
            </div>
        @endforeach
    </div>
</x-filament::page>
