<x-filament-features::auth-card action="register" class="filament-register-page">
    <div class="w-full flex justify-center">
        <x-filament::brand />
    </div>

    <h2 class="font-bold tracking-tight text-center text-2xl">
        {{ __('filament-features::register.heading') }}
    </h2>

    @csrf

    {{ $this->form }}

    <x-filament::button type="submit" form="authenticate" class="w-full">
        {{ __('filament-features::register.buttons.submit.label') }}
    </x-filament::button>

    <div class="text-center">
        <x-tables::link href="{{route('filament.auth.login')}}" >{{__('filament-features::register.buttons.login.label')}}</x-table::link>
    </div>
</x-filament-features::auth-card>.
