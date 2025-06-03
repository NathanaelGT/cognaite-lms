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
            maxScore: {{ $maxScore ?? 100 }}
        }"
        x-on:open-modal.window="if ($event.detail.id === 'quiz-result') {
            open = true;
            passed = $event.detail.passed;
            score = $event.detail.score;
            maxScore = $event.detail.maxScore;
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
            @click.away="open = false"
        >
            <div style="position: absolute; top: 0; left: 0; right: 0; height: 0.5rem; background-color: {{ $passed ? '#10b981' : '#ef4444' }}"></div>

            <div style="padding: 2rem 1.5rem;">
                <div style="margin: 0 auto; display: flex; align-items: center; justify-content: center; height: 4rem; width: 4rem; border-radius: 9999px; background-color: {{ $passed ? '#d1fae5' : '#fee2e2' }}">
                    @if($passed)
                        <svg style="height: 2rem; width: 2rem; color: #059669" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    @else
                        <svg style="height: 2rem; width: 2rem; color: #dc2626" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    @endif
                </div>

                <h3 style="margin-top: 1rem; text-align: center; font-size: 1.5rem; line-height: 2rem; font-weight: 700; color: #111827">
                    Hasil Quiz
                </h3>

                <div style="margin-top: 1rem; text-align: center;">
                    @if (!is_null($passed))
                        <p style="font-size: 1.125rem; line-height: 1.75rem; color: {{ $passed ? '#059669' : '#dc2626' }}; font-weight: 600;">
                            @if ($passed)
                                Selamat! Kompetensi Tercapai.
                            @else
                                Skor Anda Belum Mencapai Batas Minimum. Silakan Ulangi.
                            @endif
                        </p>
                    @endif

                    <div style="margin-top: 1.5rem;">
                        <p style="font-size: 0.875rem; line-height: 1.25rem; color: #6b7280">Skor Kamu</p>
                        <div style="margin-top: 0.5rem; display: flex; align-items: center; justify-content: center;">
                            <div style="position: relative; width: 100%; max-width: 20rem;">
                                <div style="position: absolute; inset: 0; display: flex; align-items: center; justify-content: center;">
                                    <span style="font-size: 0.875rem; line-height: 1.25rem; font-weight: 600; color: #111827">
                                        {{ $score }} / {{ $maxScore ?? '100' }} ({{ round(($score / ($maxScore ?? 100)) * 100) }}%)
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div style="background-color: #f9fafb; padding: 1rem 1.5rem; display: flex; flex-direction: column; gap: 0.75rem;">
                <button
                    type="button"
                    @click="open = false; $wire.set('data', [])"
                    style="margin-top: 0.75rem; width: 100%; display: inline-flex; justify-content: center; border-radius: 0.375rem; border: 1px solid #d1d5db; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); padding: 0.5rem 1rem; background-color: white; font-size: 1rem; line-height: 1.5rem; font-weight: 500; color: #374151;"
                >
                    {{ $passed ? 'Ulangi Quiz' : 'Coba Lagi' }}
                </button>

                @if($passed)
                    @if($hasNextPost)
                        <a
                            href="{{ \App\Filament\Cohort\Resources\MyBatchResource::getUrl('learn-material', ['record' => $record->slug, 'post' => $this->getNextPost()?->slug]) }}"
                            style="width: 100%; display: inline-flex; justify-content: center; border-radius: 0.375rem; border: 1px solid transparent; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); padding: 0.5rem 1rem; background-color: #059669; font-size: 1rem; line-height: 1.5rem; font-weight: 500; color: white;"
                        >
                            Lanjut ke Materi Berikutnya
                        </a>
                    @else
                        <a
                            href="{{ \App\Filament\Cohort\Resources\MyBatchResource::getUrl('view', ['record' => $record->slug]) }}"
                            style="width: 100%; display: inline-flex; justify-content: center; border-radius: 0.375rem; border: 1px solid transparent; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); padding: 0.5rem 1rem; background-color: #059669; font-size: 1rem; line-height: 1.5rem; font-weight: 500; color: white;"
                        >
                            Selesaikan Modul
                        </a>
                    @endif
                @endif
            </div>
        </div>
    </div>
</x-filament-panels::page>
