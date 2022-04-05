<?php

namespace FilamentPro\Features\Http\Livewire;

use App\Models\User;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Actions\ButtonAction;
use FilamentPro\Features\Pages\Section;

class TwoFactorAuthenticationForm extends Section
{
    protected static string $view = 'filament-features::livewire.form';

    public User $user;

    public function mount(): void
    {

    }

    protected function getTitle(): string
    {
        return __('Two Factor Authentication');
    }

    protected function getDescription(): string
    {
        return __('Add additional security to your account using two factor authentication.');
    }

    protected function getFormSchema(): array
    {
        return [
            Placeholder::make('content')->label(__('You have not enabled two factor authentication.'))->content(__('When two factor authentication is enabled, you will be prompted for a secure, random token during authentication. You may retrieve this token from your phone\'s Google Authenticator application.'))
        ];
    }

    protected function getActions(): array
    {
        return [
            ButtonAction::make('enable_two_factor_authentication')
                ->form([
//                    Placeholder::make('content')->label(false)->content(__('Are you sure you want to delete your account? Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.')),
                    TextInput::make('password')->label(false)->password()->placeholder(__('Password'))->rules('required')
                ])
                ->modalWidth('xl')
                ->action('enableTwoFactorAuthentication'),
        ];
    }

    public function enableTwoFactorAuthentication(): void {

    }
}
