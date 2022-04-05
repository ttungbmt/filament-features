<?php
namespace FilamentPro\Features\Pages;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;
use FilamentPro\Features\Features;
use FilamentPro\Features\Http\Livewire\SanctumTokens;

class APITokenManager extends Page
{
    public ?string $token_name = '';
    public array $abilities = [];
    public string $plain_text_token = '';

    protected static ?string $slug = 'user/api-tokens';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament-features::pages.api-token-manager';

    public function mount()
    {
        $this->form->fill();
    }

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('token_name')->label(__('filament-features::default.fields.token_name'))->required(),
            CheckboxList::make('abilities')
                ->label(__('filament-features::default.fields.abilities'))
                ->options(SanctumTokens::getPermissions())
                ->columns(2)
                ->required(),
        ];
    }

    public function createApiToken()
    {
        $state = $this->form->getState();
        $indexes = $state['abilities'];
        $abilities = SanctumTokens::getPermissions();
        $selected = collect($abilities)->filter(function ($item, $key) use (
            $indexes
        ) {
            return in_array($key, $indexes);
        })->toArray();
        $this->plain_text_token = auth()->user()->createToken($state['token_name'], array_values($selected))->plainTextToken;
        $this->notify('success', __('filament-features::profile.sanctum.create.notify'));
        $this->emit('tokenCreated');
        $this->reset(['token_name']);
    }

    protected function getBreadcrumbs(): array
    {
        return [
            url()->current() => self::getTitle(),
        ];
    }

    public static function getNavigationLabel(): string
    {
        return self::getTitle();
    }

    protected function getTitle(): string
    {
        return __('API Tokens');
    }

    protected static function shouldRegisterNavigation(): bool
    {
        return Features::options(Features::sactum(), 'show_in_navbar');
    }
}
