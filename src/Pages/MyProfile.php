<?php
namespace FilamentPro\Features\Pages;


use Filament\Pages\Page;
use FilamentPro\Features\Features;

class MyProfile extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament-features::pages.my-profile';

    protected static ?string $slug = 'user/my-profile';

    public function mount()
    {
        $this->user = auth()->user();
    }

    protected function getBreadcrumbs(): array
    {
        return [
            url()->current() => __('filament-features::profile.profile'),
        ];
    }

    protected static function getNavigationGroup(): ?string
    {
        return __('filament-features::profile.account');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament-features::profile.profile');
    }

    protected function getTitle(): string
    {
        return __('filament-features::profile.my_profile');
    }

    protected static function shouldRegisterNavigation(): bool
    {
        return Features::options(Features::updateProfileInformation(), 'show_in_navbar');
    }
}
