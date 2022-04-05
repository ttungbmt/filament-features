<?php

namespace FilamentPro\Features\Http\Livewire\Auth;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Http\Livewire\Concerns\CanNotify;
use FilamentPro\Features\Features;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Livewire\Component;

class ResetPassword extends Component implements HasForms
{
    use InteractsWithForms;
    use CanNotify;

    public string $email = '';
    public string $token = '';
    public string $password = '';
    public string $password_confirm = '';
    public bool $isResetting = false;
    public bool $hasBeenSent = false;

    public function mount($token = null): void
    {
        if (! is_null($token)) {
            // Verify that the token is valid before moving further.
            $this->email = request()->query('email', '');
            $this->token = $token;
            $this->isResetting = true;
        }
    }

    protected function getFormSchema(): array
    {
        if ($this->isResetting) {
            return [
                TextInput::make('password')
                    ->label(__('filament-features::default.fields.password'))
                    ->required()
                    ->password()
                    ->rules(config('filament-features.password_rules')),
                TextInput::make('password_confirm')
                    ->label(__('filament-features::default.fields.password_confirm'))
                    ->required()
                    ->password()
                    ->same('password'),
            ];
        }

        return [
            TextInput::make('email')
                ->label(__('filament-features::default.fields.email'))
                ->required()
                ->email()
                ->exists(table: config('filament-features.user_model')),
        ];
    }

    public function submit()
    {
        $data = $this->form->getState();

        if ($this->isResetting) {
            $response = Password::reset([
                'token' => $this->token,
                'email' => $this->email,
                'password' => $data['password'],
            ], function ($user, $password) {
                $user->password = Hash::make($password);
                $user->setRememberToken(Str::random(60));
                $user->save();
                event(new PasswordReset($user));
            });

            if ($response == Password::PASSWORD_RESET) {
                return redirect(route('filament.auth.login', ['email' => $this->email,'reset' => true]));
            } else {
                $this->notify('danger', __('filament-features::reset_password.notification_error'));
            }
        } else {
            $response = Password::sendResetLink(['email' => $this->email]);
            if ($response == Password::RESET_LINK_SENT) {
                $this->notify('success', __('filament-features::reset_password.notification_success'));

                $this->hasBeenSent = true;
            } else {
                $this->notify('danger', match ($response) {
                    'passwords.throttled' => __('passwords.throttled'),
                    'passwords.user' => __('passwords.user')
                });
            }
        }
    }

    public function render(): View
    {
        return view('filament-features::reset-password')
            ->layout('filament::components.layouts.base', [
                'title' => __('filament-features::reset_password.title'),
            ]);
    }
}
