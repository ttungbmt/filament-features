<x-filament::page>
    @if(\FilamentPro\Features\Features::enabled(\FilamentPro\Features\Features::updateProfileInformation()))
        @livewire(\FilamentPro\Features\Http\Livewire\UpdateProfileInformationForm::class)
    @endif

    @if(\FilamentPro\Features\Features::enabled(\FilamentPro\Features\Features::updatePasswords()))
        <hr>
        @livewire(\FilamentPro\Features\Http\Livewire\UpdatePasswordForm::class)
    @endif

    @if(\FilamentPro\Features\Features::enabled(\FilamentPro\Features\Features::twoFactorAuthentication()))
        <hr>
        @livewire(\FilamentPro\Features\Http\Livewire\TwoFactorAuthenticationForm::class)
    @endif

    @if (\FilamentPro\Features\Features::enabled(\FilamentPro\Features\Features::browserSessions()))
        <hr />
        @livewire(\FilamentPro\Features\Http\Livewire\LogoutOtherBrowserSessionsForm::class)
    @endif

    @if (\FilamentPro\Features\Features::enabled(\FilamentPro\Features\Features::accountDeletion()))
        <hr />
        @livewire(\FilamentPro\Features\Http\Livewire\DeleteUserForm::class)
    @endif



</x-filament::page>
