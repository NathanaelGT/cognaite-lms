<x-filament-panels::page
    @class([
        'fi-resource-view-record-page',
        'fi-resource-' . str_replace('/', '-', $this->getResource()::getSlug()),
        'fi-resource-record-' . $record->getKey(),
    ])
>
    {{ $this->infolist }}

    <form wire:submit.prevent="submit">
        {{ $this->form }}
    </form>

    <div x-data="{ open: false }" class="relative">
        <!-- Toggle Button -->
        <button
            x-on:click="open = !open"
            :style="open ? 'left: 16rem; top: 4.5rem;' : 'left: 1rem; top: 4.5rem;'"
            class="fixed z-50 bg-white border border-gray-300 rounded-full shadow-md p-2 hover:bg-gray-100 transition"
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

        <!-- Dark Overlay -->
        <div
            x-show="open"
            x-cloak
            style="background: black; opacity: 50%; top: 4rem;"
            class="fixed inset-0 z-30 backdrop-blur-sm"
            x-on:click="open = false"
        ></div>

        <!-- Sidebar -->
        <div
            x-show="open"
            x-cloak
            style="top: 4rem; left: 0; width: 20rem"
            class="fixed h-full w-64 bg-white border-l border-gray-200 p-4 overflow-y-auto z-40"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
        >
            <h3 class="font-bold text-lg mb-2">Daftar Materi</h3>
            <!-- Progress Bar Dummy -->
            <div style="width: 100%; background-color: #e5e7eb; border-radius: 9999px; height: 10px; margin-bottom: 0; margin-top: 1rem">
                <div style="width: 45%; background-color: rgb(217, 119, 6); height: 100%; border-radius: 9999px;"></div>
            </div>
            <!-- Persentase Dummy -->
            <div style="font-size: 0.875rem; color: rgb(55, 65, 81); margin-bottom: 1rem;">
                45% selesai
            </div>
            @foreach ($record->posts()->orderBy('order')->get() as $item)
                @php
                    $postUrl = $item->type === 'quiz'
                        ? \App\Filament\Cohort\Resources\MyBatchResource::getUrl('quiz', [
                            'record' => $record->slug,
                            'post' => $item->slug,
                        ])
                        : \App\Filament\Cohort\Resources\MyBatchResource::getUrl('learn-material', [
                            'record' => $record->slug,
                            'post' => $item->slug,
                        ]);
                @endphp
                <a
                    href="{{ $postUrl }}"
                style="
                        display: block;
                        width: 100%;
                        text-align: left;
                        padding: 0.5rem 0.75rem;
                        margin-bottom: 0.25rem;
                        border-radius: 0.375rem;
                        font-size: 0.95rem;
                        background-color: {{ $post->id === $item->id ? 'rgb(217 119 6)' : 'white' }};
                        color: {{ $post->id === $item->id ? 'white' : '#374151' }};
                        font-weight: {{ $post->id === $item->id ? '600' : 'normal' }};
                        box-shadow: {{ $post->id === $item->id ? '0 0 0 2px rgb(217 119 6)' : 'none' }};
                        transition: background-color 0.2s ease, color 0.2s ease;
                        text-decoration: none;
                    "
                    onmouseover="this.style.backgroundColor='{{ $post->id === $item->id ? 'rgb(180 90 5)' : 'rgb(254 243 199)' }}'; this.style.color='{{ $post->id === $item->id ? 'white' : 'rgb(180 90 5)' }}'"
                    onmouseout="this.style.backgroundColor='{{ $post->id === $item->id ? 'rgb(217 119 6)' : 'white' }}'; this.style.color='{{ $post->id === $item->id ? 'white' : '#374151' }}'"
                    onfocus="this.style.outline='2px solid rgb(217 119 6)'; this.style.outlineOffset='2px'"
                    onblur="this.style.outline='none'"
                >
                    {{ $item->title }}
                </a>
            @endforeach
        </div>
    </div>

    <div
        x-data="{ open: false }"
        x-on:open-modal.window="if ($event.detail.id === 'quiz-result') open = true"
        x-show="open"
        x-cloak
        class="fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center"
    >
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md mx-auto text-center">
            <h2 class="text-xl font-bold mb-4">Hasil Quiz</h2>

            @if (!is_null($passed))
                <p class="text-lg mb-2">
                    @if ($passed)
                        <span class="text-green-600 font-semibold">Selamat! Kamu lulus quiz ini 🎉</span>
                    @else
                        <span class="text-red-600 font-semibold">Maaf, kamu belum lulus 😢</span>
                    @endif
                </p>
            @endif

            <p class="text-lg">Skor kamu: <span class="font-semibold text-orange-600">{{ $score }}</span></p>

            <div class="mt-6 flex flex-col sm:flex-row justify-center gap-4">
                {{-- Tombol Ulangi Quiz --}}
                <button
                    @click="open = false; $wire.set('data', [])"
                    style="
                    display: block;
                    width: 100%;
                    text-align: center;
                    padding: 0.5rem 0.75rem;
                    margin-bottom: 0.25rem;
                    border-radius: 0.375rem;
                    font-size: 0.95rem;
                    background-color: #ef4444;
                    color: white;
                    font-weight: 600;
                    box-shadow: none;
                    transition: background-color 0.2s ease, color 0.2s ease;
                    text-decoration: none;
                    border: none;
                "
                    onmouseover="this.style.backgroundColor='#dc2626'; this.style.color='white'"
                    onmouseout="this.style.backgroundColor='#ef4444'; this.style.color='white'"
                    onfocus="this.style.outline='2px solid #ef4444'; this.style.outlineOffset='2px'"
                    onblur="this.style.outline='none'"
                >
                    Ulangi Quiz
                </button>

                @if ($passed)
                    @if ($hasNextPost) {{-- Tampilkan Selanjutnya jika lulus dan ada post selanjutnya --}}
                    {{-- Tombol Selanjutnya --}}
                    <a
                        href="{{ \App\Filament\Cohort\Resources\MyBatchResource::getUrl('learn-material', ['record' => $record->slug, 'post' => $this->getNextPost()?->slug]) }}"
                        style="
                            display: block;
                            width: 100%;
                            text-align: center;
                            padding: 0.5rem 0.75rem;
                            margin-bottom: 0.25rem;
                            border-radius: 0.375rem;
                            font-size: 0.95rem;
                            background-color: #22c55e;
                            color: white;
                            font-weight: 600;
                            box-shadow: none;
                            transition: background-color 0.2s ease, color 0.2s ease;
                            text-decoration: none;
                        "
                        onmouseover="this.style.backgroundColor='#16a34a'; this.style.color='white'"
                        onmouseout="this.style.backgroundColor='#22c55e'; this.style.color='white'"
                        onfocus="this.style.outline='2px solid #22c55e'; this.style.outlineOffset='2px'"
                        onblur="this.style.outline='none'"
                    >
                        Selanjutnya
                    </a>
                    @else {{-- Tampilkan Selesai jika lulus dan tidak ada post selanjutnya --}}
                    {{-- Tombol Selesai --}}
                    <a
                        href="{{ \App\Filament\Cohort\Resources\MyBatchResource::getUrl('view', ['record' => $record->slug]) }}"
                        style="
                            display: block;
                            width: 100%;
                            text-align: center;
                            padding: 0.5rem 0.75rem;
                            margin-bottom: 0.25rem;
                            border-radius: 0.375rem;
                            font-size: 0.95rem;
                            background-color: #22c55e;
                            color: white;
                            font-weight: 600;
                            box-shadow: none;
                            transition: background-color 0.2s ease, color 0.2s ease;
                            text-decoration: none;
                        "
                        onmouseover="this.style.backgroundColor='#16a34a'; this.style.color='white'"
                        onmouseout="this.style.backgroundColor='#22c55e'; this.style.color='white'"
                        onfocus="this.style.outline='2px solid #22c55e'; this.style.outlineOffset='2px'"
                        onblur="this.style.outline='none'"
                    >
                        Selesai
                    </a>
                    @endif
                @endif
            </div>
        </div>
    </div>
</x-filament-panels::page>
