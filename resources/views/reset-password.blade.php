<x-filament-features::auth-card action="submit" class="filament-reset-password-page">
    <div class="w-full flex justify-center">
        <x-filament::brand />
    </div>

    <h2 class="font-bold tracking-tight text-center text-2xl">
        {{ __('filament-features::reset_password.heading') }}
    </h2>

    @unless($isResetting)
        <div class="mb-4 text-sm text-gray-600">
            {{ __('filament-features::reset_password.info') }}
        </div>
    @endif

    @unless($hasBeenSent)
        @csrf
        {{ $this->form }}

        <x-filament::button type="submit" class="w-full">
            {{ __('filament-features::'.($isResetting ? 'default.buttons.submit' : 'reset_password.buttons.reset.label')) }}
        </x-filament::button>
    @else
        <span class="block text-center text-success-600 font-semibold">{{ __('filament-features::reset_password.notification_success') }}</span>
    @endunless
</x-filament-features::auth-card>
