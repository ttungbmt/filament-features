<?php

namespace FilamentPro\Features\Http\Livewire\Auth;

use Filament\Facades\Filament;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Http\Livewire\Concerns\CanNotify;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Verify extends Component implements HasForms
{
    use InteractsWithForms;
    use CanNotify;

    public bool $hasBeenSent = false;

    public function mount()
    {
        if (auth()->check() && auth()->user()?->hasVerifiedEmail()) {
            return redirect(config('filament.home_url'));
        } elseif (! auth()->check()) {
            // User is not logged in...
            return redirect(route('filament.auth.login'));
        }
    }

    public function logout()
    {
        Filament::auth()->logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect()->route('filament.auth.login');
    }

    public function resend()
    {
        Filament::auth()
            ->user()
            ->sendEmailVerificationNotification();

        $this->notify(
            'success',
            __('filament-features::verification.notification_resend')
        );
        $this->hasBeenSent = true;
    }

    public function render(): View
    {
        return view('filament-features::verify')
            ->layout('filament::components.layouts.base', [
                'title' => __('filament-features::verification.title'),
            ]);
    }
}
