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

    <x-sidebar :record="$record" :post="$post" :progressPercentage="$progressPercentage" />

    <div
        x-data="{
        open: {{ $hasAttempted ? 'true' : 'false' }},
        passed: {{ $passed ? 'true' : 'false' }},
        score: {{ $score ?? 0 }},
        minScore: {{ $post->min_score ?? 0 }} }"
        x-on:open-modal.window="if ($event.detail.id === 'quiz-result') {
        open = true;
        passed = $event.detail.passed;
        score = $event.detail.score;
        minScore = $event.detail.minScore;
    }"
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
        >
            <div style="position: absolute; top: 0; left: 0; right: 0; height: 0.5rem;"
                 :style="{ backgroundColor: passed ? '#10b981' : '#ef4444' }"></div>

            <div style="padding: 2rem 1.5rem;">
                <div style="margin: 0 auto; display: flex; align-items: center; justify-content: center; height: 4rem; width: 4rem; border-radius: 9999px;"
                     :style="{ backgroundColor: passed ? '#d1fae5' : '#fee2e2' }">
                    <svg style="height: 2rem; width: 2rem;"
                         :style="{ color: passed ? '#059669' : '#dc2626' }"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              :d="passed ? 'M5 13l4 4L19 7' : 'M6 18L18 6M6 6l12 12'" />
                    </svg>
                </div>

                <h3 style="margin-top: 1rem; text-align: center; font-size: 1.5rem; line-height: 2rem; font-weight: 700; color: #111827">
                    Hasil Quiz
                </h3>

                <div style="margin-top: 0.5rem; text-align: center;">
                    <p x-show="passed" style="font-size: 1.25rem; line-height: 1.75rem; color: #059669; font-weight: 600;">
                        Selamat! Kompetensi Tercapai.
                    </p>
                    <p x-show="!passed" style="font-size: 1.25rem; line-height: 1.75rem; color: #dc2626; font-weight: 600;">
                        Skor Anda Belum Mencapai Batas Minimum. Silakan Ulangi.
                    </p>
                </div>

                <div style="margin-top: 1rem; text-align: center;">
                    <p style="margin-top: 0.5rem; font-size: 1.25rem; line-height: 1.75rem; color: #111827; font-weight: 600;">
                        Nilai Anda: <span x-text="score"></span>/100
                    </p>
                    <p style="margin-top: 0.5rem; font-size: 1rem; line-height: 1.5rem; color: #6b7280;">
                        Nilai minimal kelulusan: <span x-text="minScore"></span>/100
                    </p>
                </div>
            </div>

            <div style="background-color: #f9fafb; padding: 1rem 1.5rem; display: flex; flex-direction: column; gap: 0.75rem;">
                <template x-if="!passed">
                    <button
                        type="button"
                        @click="open = false; $wire.set('data', [])"
                        style="margin-top: 0.75rem; width: 100%; display: inline-flex; justify-content: center; border-radius: 0.375rem; border: 1px solid #d1d5db; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); padding: 0.5rem 1rem; background-color: white; font-size: 1rem; line-height: 1.5rem; font-weight: 500; color: #374151;"
                    >
                        Kerjakan Ulang
                    </button>
                </template>

                <a
                    href="{{ \App\Filament\Cohort\Resources\MyBatchResource::getUrl('view', ['record' => $record->slug]) }}"
                    style="width: 100%; display: inline-flex; justify-content: center; border-radius: 0.375rem; border: 1px solid #d1d5db; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); padding: 0.5rem 1rem; background-color: white; font-size: 1rem; line-height: 1.5rem; font-weight: 500; color: #374151; text-decoration: none;"
                >
                    Kembali ke Daftar Materi
                </a>

                <template x-if="passed">
                    <a
                        href="{{ $nextPost ? $this->getPostUrl($nextPost) : \App\Filament\Cohort\Resources\MyBatchResource::getUrl('view', ['record' => $record->slug]) }}"
                        style="width: 100%; display: inline-flex; justify-content: center; border-radius: 0.375rem; border: 1px solid transparent; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); padding: 0.5rem 1rem; background-color: #059669; font-size: 1rem; line-height: 1.5rem; font-weight: 500; color: white; text-decoration: none;"
                    >
                        {{ $nextPost ? 'Selanjutnya' : 'Selesai' }}
                    </a>
                </template>
            </div>
        </div>
    </div>
</x-filament-panels::page>
