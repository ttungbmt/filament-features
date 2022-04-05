<?php

namespace FilamentPro\Features\Http\Livewire;

use App\Models\User;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Actions\ButtonAction;
use FilamentPro\Features\Pages\Section;

class UpdateProfileInformationForm extends Section
{
    protected static string $view = 'filament-features::livewire.form';

    public User $user;

    public function mount()
    {
        $this->user = auth()->user();
        $this->form->fill($this->user->toArray());
    }

    protected function getTitle(): string
    {
        return __('Profile Information');
    }

    protected function getDescription(): string
    {
        return __('Update your account\'s profile information and email address.');
    }

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('name')
                ->label(__('filament-features::default.fields.name'))->required(),
            TextInput::make('email')->unique(ignorable: $this->user)
                ->label(__('filament-features::default.fields.email'))->required(),
        ];
    }

    protected function getActions(): array
    {
        return [
            ButtonAction::make('save')->action('updateProfile'),
        ];
    }

    public function updateProfile(): void {
        $this->user->update($this->form->getState());
        $this->notify('success', __('filament-features::profile.personal_info.notify'));
    }
}
