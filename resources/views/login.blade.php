<x-filament-features::auth-card action="authenticate" class="filament-login-page">

    <div class="w-full flex justify-center">
        <x-filament::brand />
    </div>

    <div>
        <h2 class="font-bold tracking-tight text-center text-2xl">
            {{ __('filament::login.heading') }}
        </h2>
        @if(\FilamentPro\Features\Features::enabled(\FilamentPro\Features\Features::registration()))
            <p class="mt-2 text-sm text-center">
                {{ __('filament-features::register.or') }}
                <a class="text-primary-600" href="{{route('register')}}">
                    {{ strtolower(__('filament-features::register.heading')) }}
                </a>
            </p>
        @endif
    </div>

    {{ $this->form }}

    <x-filament::button type="submit" class="w-full">
        {{ __('filament::login.buttons.submit.label') }}
    </x-filament::button>

    @if(\FilamentPro\Features\Features::enabled(\FilamentPro\Features\Features::resetPasswords()))
        <div class="text-center">
            <a class="text-primary-600 hover:text-primary-700" href="{{route('password.request')}}">{{ __('filament-features::reset_password.buttons.request.label') }}</a>
        </div>
    @endif

</x-filament-features::auth-card>
