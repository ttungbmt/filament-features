@props(['title','description'])

<div {{$attributes->class(["grid grid-cols-2 gap-6"])}}>

    <div class="col-span-2 sm:col-span-1 flex justify-between">
        <div>
            <h3 @class(['text-lg font-medium text-gray-900','dark:text-white'=>config('filament.dark_mode')])>{{$title}}</h3>

            <p @class(['mt-1 text-sm text-gray-600','dark:text-gray-100'=>config('filament.dark_mode')])>
            {{$description}}
            </p>
        </div>
    </div>

    {{$slot}}

    <form wire:submit.prevent="callMountedAction">
        @php
            $action = $this->getMountedAction();
        @endphp

        <x-filament::modal :id="\Illuminate\Support\Str::of(static::class)->replace('\\', '\\\\') . '-action'" :width="$action?->getModalWidth()" display-classes="block">
            @if ($action)
                @if ($action->isModalCentered())
                    <x-slot name="heading">
                        {{ $action->getModalHeading() }}
                    </x-slot>

                    @if ($subheading = $action->getModalSubheading())
                        <x-slot name="subheading">
                            {{ $subheading }}
                        </x-slot>
                    @endif
                @else
                    <x-slot name="header">
                        <x-filament::modal.heading>
                            {{ $action->getModalHeading() }}
                        </x-filament::modal.heading>
                    </x-slot>
                @endif

                @if ($action->hasFormSchema())
                    {{ $this->getMountedActionForm() }}
                @endif

                <x-slot name="footer">
                    <x-filament::modal.actions :full-width="$action->isModalCentered()">
                        @foreach ($action->getModalActions() as $modalAction)
                            {{ $modalAction }}
                        @endforeach
                    </x-filament::modal.actions>
                </x-slot>
            @endif
        </x-filament::modal>
    </form>
</div>
