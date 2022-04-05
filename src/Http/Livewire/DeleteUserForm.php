<?php

namespace FilamentPro\Features\Http\Livewire;

use Filament\Facades\Filament;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Actions\ButtonAction;
use FilamentPro\Features\Actions\DeleteUser;
use FilamentPro\Features\Pages\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class DeleteUserForm extends Section
{
    protected static string $view = 'filament-features::livewire.form';

    protected function getTitle(): string
    {
        return __('Delete Account');
    }

    protected function getDescription(): string
    {
        return __('Permanently delete your account.');
    }

    protected function getFormSchema(): array
    {
        return [
            Placeholder::make('content')->label(false)->content(__('Are you sure you want to delete your account? Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.'))
        ];
    }

    protected function getActions(): array
    {
        return [
            ButtonAction::make('delete_account')
                ->form([
                    Placeholder::make('content')->label(false)->content(__('Are you sure you want to delete your account? Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.')),
                    TextInput::make('password')->label(false)->password()->placeholder(__('Password'))->rules('required')
                ])
                ->action('deleteAccount')
                ->modalHeading(__('Delete Account'))
                ->modalWidth('xl')
                ->color('danger')
                ->modalButton(__('Delete Account')),
        ];
    }

    public function deleteAccount(Request $request, array $data)
    {
        $this->resetErrorBag();

        if (! Hash::check($data['password'], Auth::user()->password)) {
            throw ValidationException::withMessages([
                'mountedActionData.password' => [__('This password does not match our records.')],
            ]);
        }

        DeleteUser::run(Filament::auth()->user()->fresh());

        Filament::auth()->logout();

        if ($request->hasSession()) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return $this->redirect(Filament::getUrl());
    }
}
