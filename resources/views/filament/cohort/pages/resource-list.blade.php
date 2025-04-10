<x-filament::page>
    <div class="container mx-auto px-4 space-y-6">
        <h2 class="text-2xl font-bold">Daftar Batch Tersedia</h2>

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

                    <div class="flex gap-2">
                        @if (!in_array($batch->id, $joinedBatchIds))
                            <x-filament::button wire:click="startConfirmJoin({{ $batch->id }})" color="primary">
                                Gabung
                            </x-filament::button>
                        @else
                            <x-filament::badge color="success">
                                Sudah Bergabung
                            </x-filament::badge>
                        @endif

                        <x-filament::button wire:click="$set('detailBatchId', {{ $batch->id }})" color="secondary" outlined>
                            Detail
                        </x-filament::button>
                    </div>
                </div>

                @if ($detailBatchId === $batch->id)
                    <div class="mt-4 border-t pt-4 text-sm text-gray-800 space-y-2">
                        <div><span class="font-semibold">Nama:</span> {{ $batch->name }}</div>
                        <div><span class="font-semibold">Deskripsi:</span> {{ $batch->description }}</div>
                        <div><span class="font-semibold">Harga:</span> {{ $batch->price ? 'Rp' . number_format($batch->price, 0, ',', '.') : 'Gratis' }}</div>
                        <div>
                            <span class="font-semibold">Kursus:</span>
                            <ul class="list-disc list-inside">
                                @forelse ($batch->courses as $course)
                                    <li>{{ $course->title }}</li>
                                @empty
                                    <li>Belum ada kursus.</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                @endif
            </div>
        @empty
            <p class="text-gray-600">Belum ada batch yang tersedia saat ini.</p>
        @endforelse

        {{-- Modal Konfirmasi --}}
        @if ($confirmingBatchId)
            <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white p-6 rounded-xl w-full max-w-md space-y-4 border border-gray-300 shadow-lg">
                    <h3 class="text-lg font-bold text-gray-800">Konfirmasi Bergabung</h3>
                    <p class="text-gray-700">Apakah kamu yakin ingin bergabung dengan batch ini?</p>
                    <div class="flex justify-end gap-3 mt-4">
                        <x-filament::button wire:click="cancelConfirm" color="danger" outlined>
                            Tidak Jadi
                        </x-filament::button>
                        <x-filament::button wire:click="confirmJoin" color="primary">
                            Ya, Gabung
                        </x-filament::button>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-filament::page>
