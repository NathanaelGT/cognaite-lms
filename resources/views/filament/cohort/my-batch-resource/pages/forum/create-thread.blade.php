<x-filament-panels::page>
    <form wire:submit.prevent="submit">
        {{ $this->form }}

        <div style="margin-top: 1.5rem; display: flex; justify-content: flex-end;">
            <x-filament::button color="primary" type="submit">
                Kirim Pertanyaan
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>
