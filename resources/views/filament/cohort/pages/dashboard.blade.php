<x-filament-panels::page>
    <div class="space-y-8">
        @if($hasOngoingBatches)
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-semibold">Sedang Dikerjakan</h2>
                    <span class="text-sm text-gray-500">{{ $ongoingBatches->count() }} batch aktif</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($ongoingBatches as $batch)
                        <div class="border rounded-lg p-4 bg-white hover:shadow-md transition-shadow flex flex-col">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="font-medium text-gray-900">{{ $batch->name }}</h3>
                                <span class="px-2 py-1 {{ $batch->progress_percentage > 70 ? 'bg-green-100 text-green-800' : ($batch->progress_percentage > 30 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }} text-xs rounded-full">
                                    {{ $batch->progress_percentage }}%
                                </span>
                            </div>

                            <div class="w-full bg-gray-200 rounded-full h-2 mb-3 mt-auto">
                                <div
                                    class="h-2 rounded-full {{ $batch->progress_percentage > 70 ? 'bg-green-600' : ($batch->progress_percentage > 30 ? 'bg-yellow-600' : 'bg-red-600') }}"
                                    style="width: {{ $batch->progress_percentage }}%"
                                ></div>
                            </div>

                            <div class="flex justify-between items-center text-xs text-gray-500 mt-auto">
                                <span class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $batch->duration }} menit
                                </span>
                                <span class="text-xs">
                                    Update: {{ $batch->updated_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @if($hasCompletedBatches)
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-semibold">Sudah Selesai</h2>
                    <span class="text-sm text-gray-500">{{ $completedBatches->count() }} batch selesai</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($completedBatches as $batch)
                        <div class="border rounded-lg p-4 bg-white hover:shadow-md transition-shadow flex flex-col">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="font-medium text-gray-900">{{ $batch->name }}</h3>
                                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Selesai
                                </span>
                            </div>

                            <div class="w-full bg-gray-200 rounded-full h-2 mb-3 mt-auto">
                                <div class="bg-green-600 h-2 rounded-full" style="width: 100%"></div>
                            </div>

                            <div class="flex justify-between items-center text-xs text-gray-500 mt-auto">
                                <span class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $batch->duration }} menit
                                </span>
                                <span class="text-xs">
                                    Selesai: {{ $batch->updated_at->format('d M Y') }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @if(!$hasOngoingBatches && !$hasCompletedBatches)
            <div class="p-6 bg-white rounded-lg shadow text-center max-w-md mx-auto">
                <div class="py-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto text-gray-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900">Belum ada batch</h3>
                    <p class="mt-1 text-sm text-gray-500">Anda belum tergabung dalam batch apapun</p>
                </div>
            </div>
        @endif
    </div>
</x-filament-panels::page>
