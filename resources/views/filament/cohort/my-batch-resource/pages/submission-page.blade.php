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
            class="fixed h-full w-64 bg-white border-l border-gray-200 p-4 overflow-y-auto z-40"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
        >
            <h3 class="font-bold text-lg mb-2">Daftar Materi</h3>
            <div style="width: 100%; background-color: #e5e7eb; border-radius: 9999px; height: 10px; margin-bottom: 0; margin-top: 1rem">
                <div style="width: 45%; background-color: rgb(217, 119, 6); height: 100%; border-radius: 9999px;"></div>
            </div>
            <div style="font-size: 0.875rem; color: rgb(55, 65, 81); margin-bottom: 1rem;">
                45% selesai
            </div>
            @foreach ($record->posts()->orderBy('order')->get() as $item)
                @php
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
        x-data="{
            open: {{ $hasSubmitted ? 'true' : 'false' }},
            submitted: true,
            status: '{{ $submissionStatus }}'
        }"
        x-on:submission-success.window="open = true; submitted = true"
        x-show="open"
        x-cloak
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
        style="background-color: rgba(0, 0, 0, 0.5)"
    >
        <div
            x-show="open"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="relative w-full max-w-md bg-white rounded-xl shadow-2xl overflow-hidden"
            @click.away="open = false"
        >
            <div style="position: absolute; top: 0; left: 0; right: 0; height: 0.5rem; background-color: #10b981"></div>

            <div style="padding: 2rem 1.5rem;">
                <div style="margin: 0 auto; display: flex; align-items: center; justify-content: center; height: 4rem; width: 4rem; border-radius: 9999px; background-color: #d1fae5">
                    <svg style="height: 2rem; width: 2rem; color: #059669" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>

                <h3 style="margin-top: 1rem; text-align: center; font-size: 1.5rem; line-height: 2rem; font-weight: 700; color: #111827">
                    Submission Dikirim
                </h3>

                <div style="margin-top: 1rem; text-align: center;">
                    <p style="margin-top: 0.5rem; font-size: 1rem; line-height: 1.5rem; color: #6b7280;">
                        Silahkan menunggu untuk dinilai oleh mentor
                    </p>
                </div>
            </div>

            <div style="background-color: #f9fafb; padding: 1rem 1.5rem; display: flex; flex-direction: column; gap: 0.75rem;">
                <button
                    type="button"
                    @click="open = false; $wire.set('data.file_path', null); $wire.set('data.notes', null)"
                    style="margin-top: 0.75rem; width: 100%; display: inline-flex; justify-content: center; border-radius: 0.375rem; border: 1px solid #d1d5db; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); padding: 0.5rem 1rem; background-color: white; font-size: 1rem; line-height: 1.5rem; font-weight: 500; color: #374151;"
                >
                    Edit Submission
                </button>

                <a
                    href="{{ \App\Filament\Cohort\Resources\MyBatchResource::getUrl('view', ['record' => $record->slug, 'activeRelationManager' => 1]) }}"
                    style="width: 100%; display: inline-flex; justify-content: center; border-radius: 0.375rem; border: 1px solid transparent; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); padding: 0.5rem 1rem; background-color: #059669; font-size: 1rem; line-height: 1.5rem; font-weight: 500; color: white; text-decoration: none;"
                >
                    Kembali ke Daftar Materi
                </a>
            </div>
        </div>
    </div>
</x-filament-panels::page>
