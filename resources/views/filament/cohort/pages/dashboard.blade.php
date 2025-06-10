<x-filament-panels::page>
    <div class="space-y-8">
        {{-- Batch yang sedang dikerjakan --}}
        @if($hasOngoingBatches)
            <div class="p-6 bg-white rounded-lg shadow">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold">Sedang Dikerjakan</h2>
                    <span class="text-sm text-gray-500">Menampilkan {{ $ongoingBatches->count() }} batch</span>
                </div>

                <div class="space-y-4">
                    @foreach($ongoingBatches as $batch)
                        <div class="border-b pb-4 last:border-b-0 last:pb-0">
                            <div class="flex justify-between items-center mb-1">
                                <h3 class="font-medium">{{ $batch->name }}</h3>
                                <span class="text-sm font-medium {{ $batch->progress_percentage > 70 ? 'text-green-600' : ($batch->progress_percentage > 30 ? 'text-yellow-600' : 'text-red-600') }}">
                                    {{ $batch->progress_percentage }}%
                                </span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5 mb-1">
                                <div
                                    class="h-2.5 rounded-full {{ $batch->progress_percentage > 70 ? 'bg-green-600' : ($batch->progress_percentage > 30 ? 'bg-yellow-600' : 'bg-red-600') }}"
                                    style="width: {{ $batch->progress_percentage }}%"
                                ></div>
                            </div>
                            <p class="text-xs text-gray-500">
                                Terakhir diupdate: {{ $batch->updated_at->diffForHumans() }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Batch yang sudah selesai --}}
        @if($hasCompletedBatches)
            <div class="p-6 bg-white rounded-lg shadow">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold">Sudah Selesai</h2>
                    <span class="text-sm text-gray-500">Menampilkan {{ $completedBatches->count() }} batch</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($completedBatches as $batch)
                        <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="font-medium">{{ $batch->name }}</h3>
                                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">
                                    Selesai
                                </span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2 mb-2">
                                <div
                                    class="bg-green-600 h-2 rounded-full"
                                    style="width: 100%"
                                ></div>
                            </div>
                            <div class="flex justify-between text-xs text-gray-500">
                                <span>Durasi: {{ $batch->duration }} menit</span>
                                <span>Selesai: {{ $batch->updated_at->format('d M Y') }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Jika tidak ada batch sama sekali --}}
        @if(!$hasOngoingBatches && !$hasCompletedBatches)
            <div class="p-6 bg-white rounded-lg shadow text-center">
                <p class="text-gray-500 py-4">Anda belum tergabung dalam batch apapun</p>
            </div>
        @endif
    </div>
</x-filament-panels::page>
