<x-filament-panels::page
    @class([
        'fi-resource-view-record-page',
        'fi-resource-' . str_replace('/', '-', $this->getResource()::getSlug()),
        'fi-resource-record-' . $record->getKey(),
    ])
>
    {{ $this->infolist }}

    <x-sidebar :record="$record" :post="$post" :progressPercentage="$progressPercentage" />

    <livewire:ai-chatbox :batch-id="$record->id" />
</x-filament-panels::page>
