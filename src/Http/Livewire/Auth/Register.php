<?php
namespace FilamentPro\Features\Http\Livewire\Auth;

use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Filament\Facades\Filament;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use FilamentPro\Features\Features;
use Illuminate\Contracts\View\View;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Illuminate\Auth\Events\Registered;

class Register extends Component implements HasForms
{
    use InteractsWithForms;
    use WithRateLimiting;

    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirm = '';

    public function mount()
    {
        if (Filament::auth()->check()) {
            return redirect()->intended(Filament::getUrl());
        }
    }

    public function messages(): array
    {
        return [
            'email.unique' => __('filament-features::register.notification_unique'),
        ];
    }

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('name')
                ->label(__('filament-features::default.fields.name'))
                ->required(),
            TextInput::make('email')
                ->label(__('filament-features::default.fields.email'))
                ->required()
                ->email()
                ->autocomplete()
                ->unique(table: config('filament-features.user_model')),
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

    protected function prepareModelData($data): array
    {
        $preparedData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ];

        return $preparedData;
    }

    public function register()
    {
        try {
            $this->rateLimit(5);
        } catch (TooManyRequestsException $exception) {
            $this->addError('email', __('filament-features::register.messages.throttled', [
                'seconds' => $exception->secondsUntilAvailable,
                'minutes' => ceil($exception->secondsUntilAvailable / 60),
            ]));

            return;
        }

        $data = $this->form->getState();

        $preparedData = $this->prepareModelData($data);

        $user = config('filament-features.user_model')::create($preparedData);

        event(new Registered($user));

        Filament::auth()->login($user);

        return redirect()->to(Features::options(Features::registration(), 'redirect_url'), config('filament.home_url', '/'));
    }

    public function render(): View
    {
        return view('filament-features::register')
            ->layout('filament::components.layouts.base', [
                'title' => __('filament-features::register.title'),
            ]);
    }
}
