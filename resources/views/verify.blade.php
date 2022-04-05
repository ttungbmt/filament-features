<x-filament-features::auth-card action="logout" class="">
    <div class="w-full flex justify-center">
        <x-filament::brand />
    </div>

    <div class="space-y-8">
        <h2 class="font-bold tracking-tight text-center text-2xl">
            {{ __('filament-features::verification.heading') }}
        </h2>
        <div>
            {{ __('filament-features::verification.before_proceeding') }}
            @unless($hasBeenSent)
                {{ __('filament-features::verification.not_receive') }}

                <a class="text-primary-600" href="#" wire:click="resend">
                    {{ __('filament-features::verification.request_another') }}
                </a>

            @else
                <span class="block text-success-600 font-semibold">{{ __('filament-features::verification.notification_success') }}</span>
            @endunless
        </div>
    </div>

    {{ $this->form }}

    <x-filament::button type="submit" class="w-full">
        {{ __('filament-features::verification.submit.label') }}
    </x-filament::button>
</x-filament-features::auth-card>
