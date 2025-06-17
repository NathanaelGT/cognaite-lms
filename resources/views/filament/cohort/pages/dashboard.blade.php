<x-filament-panels::page>
    <div class="space-y-10">
        @if($hasOngoingBatches)
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-semibold">Sedang Dikerjakan</h2>
                    <span class="text-sm text-gray-500">{{ $ongoingBatches->count() }} batch aktif</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($ongoingBatches as $batch)
                        <div class="border rounded-lg p-4 bg-white hover:shadow-md transition-shadow flex flex-col">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="font-medium text-gray-900">{{ $batch->name }}</h3>
                                <span class="px-2 py-1 text-xs rounded-full"
                                      style="
                                          background-color: rgba(217, 119, 6, 0.1);
                                          color: rgb(217, 119, 6);
                                      ">
                                    {{ $batch->progress_percentage }}%
                                </span>
                            </div>

                            <div style="
                                width: 100%;
                                height: 10px;
                                background-color: #e5e7eb;
                                border-radius: 9999px;
                                overflow: hidden;
                                margin-bottom: 0.75rem;
                            ">
                                <div style="
                                    width: {{ $batch->progress_percentage }}%;
                                    height: 100%;
                                    background-color: rgb(217, 119, 6);
                                    border-radius: 9999px;
                                "></div>
                            </div>
                            <p style="
                                text-align: center;
                                font-size: 0.875rem;
                                color: rgb(55, 65, 81);
                                margin-top: -0.5rem;
                            ">
                                {{ $batch->progress_percentage }}% selesai
                            </p>

                            <div class="flex justify-between items-center text-xs text-gray-500 mt-auto">
                                <span class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1"
                                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $batch->duration }} menit
                                </span>
                                <span>
                                    Update: {{ $batch->updated_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @if($hasCompletedBatches)
            <div class="space-y-4 mt-12">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-semibold">Sudah Selesai</h2>
                    <span class="text-sm text-gray-500">{{ $completedBatches->count() }} batch selesai</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($completedBatches as $batch)
                        <div class="border rounded-lg p-4 bg-white hover:shadow-md transition-shadow flex flex-col">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="font-medium text-gray-900">{{ $batch->name }}</h3>
                                <span class="px-2 py-1 text-xs rounded-full flex items-center"
                                      style="
                                          background-color: rgba(5, 150, 105, 0.1);
                                          color: rgb(217, 119, 6);
                                      ">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1"
                                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Selesai
                                </span>
                            </div>

                            <div style="
                                width: 100%;
                                height: 10px;
                                background-color: #e5e7eb;
                                border-radius: 9999px;
                                overflow: hidden;
                                margin-bottom: 0.75rem;
                            ">
                                <div style="
                                    width: 100%;
                                    height: 100%;
                                    background-color: rgb(217, 119, 6);
                                    border-radius: 9999px;
                                "></div>
                            </div>
                            <p style="
                                text-align: center;
                                font-size: 0.875rem;
                                color: rgb(55, 65, 81);
                                margin-top: -0.5rem;
                            ">
                                100% selesai
                            </p>

                            <div class="flex justify-between items-center text-xs text-gray-500 mt-auto">
                                <span class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1"
                                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $batch->duration }} menit
                                </span>
                                <span>
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
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto text-gray-400 mb-3"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900">Belum ada batch</h3>
                    <p class="mt-1 text-sm text-gray-500">Anda belum tergabung dalam batch apapun</p>
                </div>
            </div>
        @endif
    </div>
</x-filament-panels::page>
