<x-filament-features::auth-card action="authenticate">
    <div class="w-full flex justify-center">
        <x-filament::brand />
    </div>

    <h2 class="font-bold tracking-tight text-center text-2xl">
        {{ __('filament-features::account-expired.heading') }}
    </h2>

    <p class="text-center">
        {{ __('filament-features::account-expired.message') }}
    </p>

    <div class="text-center">
        <a class="text-primary-600 hover:text-primary-700" href="{{ route('filament.auth.login') }}">
            {{ __('filament-features::account-expired.buttons.back_to_login.label') }}
        </a>
    </div>
</x-filament-features::auth-card>
