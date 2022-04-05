<x-filament-features::grid-section>

    <x-slot name="title">
        {{$this->getTitle()}}
    </x-slot>

    <x-slot name="description">
        {{$this->getDescription()}}
    </x-slot>

    <x-filament::card>
        {{$this->form}}

        <x-filament::pages.actions :actions="$this->getCachedActions()"/>
    </x-filament::card>
</x-filament-features::grid-section>
