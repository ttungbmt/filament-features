<?php

namespace FilamentPro\Features\Http\Livewire\Auth;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class AccountExpired extends Component
{
    public function render(): View
    {
        return view('filament-features::account-expired')
            ->layout('filament::components.layouts.base', [
                'title' => __('filament-features::account_expired.title'),
            ]);
    }
}
