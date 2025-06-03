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
