<x-filament::page>
    <div class="container mx-auto px-4 space-y-6">
        <h2 class="text-2xl font-bold">Batch Saya</h2>

        @forelse ($batches as $batch)
            <div class="p-4 bg-white rounded-xl shadow border space-y-2">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800">{{ $batch->name }}</h3>
                        <p class="text-sm text-gray-600">{{ $batch->description }}</p>
                        <p class="text-sm text-gray-500 italic">
                            {{ $batch->price ? 'Berbayar - Rp' . number_format($batch->price, 0, ',', '.') : 'Gratis' }}
                        </p>
                    </div>

                    <div class="flex items-center gap-2">
                        <x-filament::button color="danger" wire:click="dropBatch({{ $batch->id }})">
                            Keluar
                        </x-filament::button>

                        <x-filament::button wire:click="toggleDetail({{ $batch->id }})" color="gray" size="sm">
                            Detail
                        </x-filament::button>
                    </div>
                </div>

                @if ($expandedBatchId === $batch->id)
                    <div class="mt-4 border-t pt-4">
                        <h4 class="font-medium text-gray-700">Kursus dalam batch ini:</h4>
                        <ul class="list-disc list-inside text-sm text-gray-800 mt-1">
                            @forelse ($batch->courses as $course)
                                <li>{{ $course->title }}</li>
                            @empty
                                <li>Belum ada kursus.</li>
                            @endforelse
                        </ul>
                    </div>
                @endif
            </div>
        @empty
            <p class="text-gray-600">Kamu belum mengambil batch apapun.</p>
        @endforelse
    </div>
</x-filament::page>
