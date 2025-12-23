@props(['record', 'post', 'progressPercentage'])

<div x-data="{ open: false }" class="relative">
    <button
        x-on:click="open = !open"
        :style="open ? 'left: 16rem; top: 4.5rem;' : 'left: 1rem; top: 4.5rem;'"
        class="fixed z-50 bg-white border border-gray-300 rounded-full shadow-md p-2 hover:bg-gray-100 transition-all duration-200 ease-in-out"
        title="Toggle Daftar Materi"
    >
        <svg
            x-show="!open"
            xmlns="http://www.w3.org/2000/svg"
            class="h-6 w-6 text-gray-700"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            stroke-width="1.5"
        >
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 5.25h16.5M3.75 12h16.5M3.75 18.75h16.5" />
        </svg>
        <svg
            x-show="open"
            xmlns="http://www.w3.org/2000/svg"
            class="h-6 w-6 text-gray-700"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            stroke-width="1.5"
        >
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
        </svg>
    </button>

    <div
        x-show="open"
        x-cloak
        style="background: black; opacity: 50%; top: 4rem;"
        class="fixed inset-0 z-30 backdrop-blur-sm"
        x-on:click="open = false"
    ></div>

    <div
        x-show="open"
        x-cloak
        style="top: 4rem; left: 0; width: 20rem"
        class="fixed h-full w-64 bg-white border-l border-gray-200 z-40 flex flex-col"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full"
    >
        <div class="flex-1 overflow-y-auto p-4">
            <h3 class="font-bold text-lg mb-2">Daftar Materi</h3>

            <div style="width: 100%; background-color: #e5e7eb; border-radius: 9999px; height: 10px; margin-top: 1rem">
                <div style="width: {{ $progressPercentage }}%; background-color: rgb(217, 119, 6); height: 100%; border-radius: 9999px;"></div>
            </div>

            <div style="font-size: 0.875rem; color: rgb(55, 65, 81); margin-bottom: 1rem;">
                {{ $progressPercentage }}% selesai
            </div>

            @php
                $previousPassed = true;
            @endphp

            @foreach ($record->posts()->orderBy('order')->get() as $item)
                @php
                    $isPassed = auth()->user()->postProgress->where('post_id', $item->id)->first()->is_passed ?? false;

                    $isAccessible = $previousPassed;

                    if (!$isPassed && $item->order >= $post->order) {
                        $previousPassed = false;
                    }

                    $postUrl = match ($item->type) {
                        'quiz' => \App\Filament\Cohort\Resources\MyBatchResource::getUrl('quiz', [
                            'record' => $record->slug,
                            'post' => $item->slug,
                        ]),
                        'submission' => \App\Filament\Cohort\Resources\MyBatchResource::getUrl('submission', [
                            'record' => $record->slug,
                            'post' => $item->slug,
                        ]),
                        default => \App\Filament\Cohort\Resources\MyBatchResource::getUrl('learn-material', [
                            'record' => $record->slug,
                            'post' => $item->slug,
                        ]),
                    };
                @endphp

                <div class="relative">
                    <a
                        href="{{ $isAccessible ? $postUrl : '#' }}"
                        @if(!$isAccessible)
                            onclick="event.preventDefault();"
                        title="Selesaikan materi sebelumnya terlebih dahulu"
                        @endif
                        style="
                    display: block;
                    width: 100%;
                    text-align: left;
                    padding: 0.5rem 0.75rem;
                    margin-bottom: 0.25rem;
                    border-radius: 0.375rem;
                    font-size: 0.95rem;
                    background-color: {{ $post->id === $item->id ? 'rgb(217 119 6)' : ($isAccessible ? 'white' : '#f3f4f6') }};
                    color: {{ $post->id === $item->id ? 'white' : ($isAccessible ? '#374151' : '#9ca3af') }};
                    font-weight: {{ $post->id === $item->id ? '600' : 'normal' }};
                    box-shadow: {{ $post->id === $item->id ? '0 0 0 2px rgb(217 119 6)' : 'none' }};
                    transition: background-color 0.2s ease, color 0.2s ease;
                    text-decoration: none;
                    cursor: {{ $isAccessible ? 'pointer' : 'not-allowed' }};
                "
                        @if($isAccessible)
                            onmouseover="this.style.backgroundColor='{{ $post->id === $item->id ? 'rgb(180 90 5)' : 'rgb(254 243 199)' }}'; this.style.color='{{ $post->id === $item->id ? 'white' : 'rgb(180 90 5)' }}'"
                        onmouseout="this.style.backgroundColor='{{ $post->id === $item->id ? 'rgb(217 119 6)' : 'white' }}'; this.style.color='{{ $post->id === $item->id ? 'white' : '#374151' }}'"
                        @endif
                    >
                        {{ $item->title }}
                        @if(!$isAccessible)
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        @endif
                    </a>

                    @if(!$isAccessible)
                        <div class="absolute inset-0 bg-gray-100 opacity-50 rounded-md"></div>
                    @endif
                </div>
            @endforeach
        </div>

        <div
            class="sticky bottom-0"
            style="
                background-color: white;
                border-top: 1px solid #e5e7eb;
                padding: 0.75rem;
                z-index: 10;
            "
        >
            <a
                href="{{ \App\Filament\Cohort\Resources\MyBatchResource::getUrl('forum', [
                    'record' => $record->slug,
                    ]) . '?post=' . $post->id }}"
                style="
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            width: 100%;
            padding: 0.6rem 0.75rem;
            border-radius: 0.375rem;
            font-size: 0.95rem;
            font-weight: 600;
            background-color: rgb(217 119 6);
            color: white;
            text-decoration: none;
        "
                onmouseover="this.style.backgroundColor='rgb(180 90 5)'"
                onmouseout="this.style.backgroundColor='rgb(217 119 6)'"
            >
                <svg xmlns="http://www.w3.org/2000/svg" style="width: 1.1rem; height: 1.1rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M8 10h8m-8 4h5m-7 6l-4-4V4a2 2 0 012-2h16a2 2 0 012 2v12a2 2 0 01-2 2H7z" />
                </svg>

                Forum Diskusi
            </a>
        </div>
    </div>
</div>
