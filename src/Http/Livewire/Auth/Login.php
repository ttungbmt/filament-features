<?php

namespace FilamentPro\Features\Http\Livewire\Auth;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Facades\Filament;
use Filament\Http\Livewire\Auth\Login as FilamentLogin;
use Filament\Http\Livewire\Concerns\CanNotify;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use FilamentPro\Features\Features;
use Illuminate\Contracts\View\View;

class Login extends FilamentLogin
{
    use CanNotify;

    public function mount(): void
    {
        parent::mount();

        if ($email = request()->input('email')) {
            $this->form->fill(['email' => $email]);
        }

        if (request()->query('reset')) {
            $this->notify('success', __('passwords.reset'), true);
        }
    }

    public function authenticate(): ?LoginResponse
    {
        try {
            $this->rateLimit(5);
        } catch (TooManyRequestsException $exception) {
            $this->addError('email', __('filament::login.messages.throttled', [
                'seconds' => $exception->secondsUntilAvailable,
                'minutes' => ceil($exception->secondsUntilAvailable / 60),
            ]));

            return null;
        }

        $data = $this->form->getState();

        if (Features::enabled(Features::twoFactorAuthentication())) {
//            if (! $user->hasTwoFactorCode() || $user->twoFactorCodeIsExpired()) {
//                $user->notify(new TwoFactorCode);
//            }
//
//            session()->put('filament.id', $user->getKey());
//            session()->put('filament.remember', $data['remember']);
//
//            return redirect()->route('filament.account.two-factor');
        }

        if (! Filament::auth()->attempt([
            'email' => $data['email'],
            'password' => $data['password'],
        ], $data['remember'])) {
            $this->addError('email', __('filament::login.messages.failed'));

            return null;
        }

        if(Features::enabled(Features::accountExpired()) && Filament::auth()->user()->isExpired()){
            Filament::auth()->user()->extendExiryDay();
        }

        return app(LoginResponse::class);
    }


    public function render(): View
    {
        return view('filament-features::login')
            ->layout('filament::components.layouts.base', [
                'title' => __('filament::login.title'),
            ]);
    }
}
