<?php

namespace FilamentPro\Features\Http\Livewire;

use Filament\Facades\Filament;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Actions\ButtonAction;
use FilamentPro\Features\Pages\Section;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Jenssegers\Agent\Agent;

class LogoutOtherBrowserSessionsForm extends Section
{
    protected static string $view = 'filament-features::livewire.logout-other-browser-sessions-form';

    protected function getTitle(): string
    {
        return __('Browser Sessions');
    }

    protected function getDescription(): string
    {
        return __('Manage and log out your active sessions on other browsers and devices.');
    }

    protected function getFormSchema(): array
    {
        return [
            Placeholder::make('content')->label(false)->content(__('If necessary, you may log out of all of your other browser sessions across all of your devices. Some of your recent sessions are listed below; however, this list may not be exhaustive. If you feel your account has been compromised, you should also update your password.'))
        ];
    }

    protected function getActions(): array
    {
        return [
            ButtonAction::make('log_out_other_browser_sessions')
                ->form([
                    Placeholder::make('content')->label(false)->content(__('Please enter your password to confirm you would like to log out of your other browser sessions across all of your devices.')),
                    TextInput::make('password')->label(false)->password()->placeholder(__('Password'))->required()
                ])
                ->action('logOutOtherBrowserSessions')
                ->modalHeading(__('Log Out Other Browser Sessions'))
                ->modalWidth('xl')
                ->modalButton(__('Log Out Other Browser Sessions')),
        ];
    }

    public function logOutOtherBrowserSessions(array $data)
    {
        $this->resetErrorBag();

        if (! Hash::check($data['password'], Filament::auth()->user()->password)) {
            throw ValidationException::withMessages([
                'mountedActionData.password' => [__('This password does not match our records.')],
            ]);
        }

        Filament::auth()->logoutOtherDevices($data['password']);

        $this->deleteOtherSessionRecords();

        $this->notify('success', __('Logout other devices successfully'));
    }

    /**
     * Delete the other browser session records from storage.
     *
     * @return void
     */
    protected function deleteOtherSessionRecords()
    {
        if (config('session.driver') !== 'database') {
            return;
        }

        DB::connection(config('session.connection'))->table(config('session.table', 'sessions'))
            ->where('user_id', Filament::auth()->user()->getAuthIdentifier())
            ->where('id', '!=', request()->session()->getId())
            ->delete();
    }

    /**
     * Get the current sessions.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getSessionsProperty()
    {
        if (config('session.driver') !== 'database') {
            return collect();
        }

        return collect(
            DB::connection(config('session.connection'))->table(config('session.table', 'sessions'))
                ->where('user_id', Auth::user()->getAuthIdentifier())
                ->orderBy('last_activity', 'desc')
                ->get()
        )->map(function ($session) {
            return (object) [
                'agent' => $this->createAgent($session),
                'ip_address' => $session->ip_address,
                'is_current_device' => $session->id === request()->session()->getId(),
                'last_active' => Carbon::createFromTimestamp($session->last_activity)->diffForHumans(),
            ];
        });
    }

    /**
     * Create a new agent instance from the given session.
     *
     * @param  mixed  $session
     * @return \Jenssegers\Agent\Agent
     */
    protected function createAgent($session)
    {
        return tap(new Agent, function ($agent) use ($session) {
            $agent->setUserAgent($session->user_agent);
        });
    }
}
