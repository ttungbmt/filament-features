<?php

namespace FilamentPro\Features\Http\Livewire;

use App\Models\User;
use Closure;
use Filament\Facades\Filament;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Actions\ButtonAction;
use FilamentPro\Features\Pages\Section;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Rules\Password;

class UpdatePasswordForm extends Section
{
    protected static string $view = 'filament-features::livewire.form';

    public User $user;

    public ?string $current_password = '';

    public ?string $password = '';

    public ?string $password_confirmation = '';

    public function mount(): void
    {
        $this->user = auth()->user();
        $this->form->fill();
    }

    protected function getTitle(): string
    {
        return __('Update Password');
    }

    protected function getDescription(): string
    {
        return __('Update your account\'s profile information and email address.');
    }

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('current_password')
                ->label(__('Current Password'))
                ->password()
                ->required()
                ->rules([
                    fn() => function (string $attribute, $value, Closure $fail) {
                        if (!Hash::check($value, $this->user->password)) {
                            $fail(__('The provided password does not match your current password.'));
                        }
                    }
                ]),
            TextInput::make('password')
                ->label(__('New Password'))
                ->password()
                ->rules(config('filament-features.password_rules'))
                ->different('current_password')
                ->required(),
            TextInput::make('password_confirmation')
                ->label(__('Confirm Password'))
                ->password()
                ->same('password')
                ->required(),
        ];
    }

    protected function getActions(): array
    {
        return [
            ButtonAction::make('save')->action('updatePassword'),
        ];
    }

    public function updatePassword()
    {
        $data = $this->form->getState();
        $this->user->update([
            'password' => Hash::make($data['password']),
        ]);
        session()->forget('password_hash_web');
        Filament::auth()->login($this->user);
        $this->notify('success', __('filament-features::profile.password.notify'));
        $this->reset(['current_password', 'password', 'password_confirmation']);
    }
}
