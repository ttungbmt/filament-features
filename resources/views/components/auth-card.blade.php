@props(['action', 'class' => 'filament-auth-page'])

<div class="flex items-center justify-center min-h-screen {{$class}}">
    <div class="p-2 max-w-md space-y-8 w-screen">
        <form wire:submit.prevent="{{$action}}" @class([
            'bg-white space-y-8 shadow border border-gray-300 rounded-2xl p-8',
            'dark:bg-gray-800 dark:border-gray-700' => config('filament.dark_mode'),
        ])>
            {{$slot}}
        </form>

        <x-filament::notification-manager />

        <x-filament::footer />
    </div>
</div>


