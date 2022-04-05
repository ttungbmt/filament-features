<x-filament::page>
    <x-filament-features::grid-section class="mt-8">

        <x-slot name="title">
            {{ __('Create API Token') }}
        </x-slot>

        <x-slot name="description">
            {{ __('API tokens allow third-party services to authenticate with our application on your behalf.') }}
        </x-slot>

        <div class="space-y-3">

            <form wire:submit.prevent="createApiToken" class="col-span-2 sm:col-span-1 mt-5 md:mt-0">

                <x-filament::card>
                    @if($plain_text_token)
                        <input type="text" disabled @class(['w-full py-1 px-3 rounded-lg bg-gray-100 border-gray-200',' dark:bg-gray-900 dark:border-gray-700'=>config('filament.dark_mode')]) name="plain_text_token" value="{{$plain_text_token}}" />
                    @endif

                    {{$this->form}}

                    <div class="text-right">
                        <x-filament::button type="submit">
                            {{ __('filament-features::profile.sanctum.create.submit.label') }}
                        </x-filament::button>
                    </div>
                </x-filament::card>
            </form>

        </div>
    </x-filament-features::grid-section>

    <x-filament-features::grid-section class="mt-8">

        <x-slot name="title">
            {{ __('Manage API Tokens') }}
        </x-slot>

        <x-slot name="description">
            {{ __('You may delete any of your existing tokens if they are no longer needed.') }}
        </x-slot>

        <div class="space-y-3">

            @livewire(\FilamentPro\Features\Http\Livewire\SanctumTokens::class)

        </div>
    </x-filament-features::grid-section>
</x-filament::page>
