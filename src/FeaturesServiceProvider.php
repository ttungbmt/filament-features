<?php

namespace FilamentPro\Features;

use Filament\Facades\Filament;
use Filament\Navigation\UserMenuItem;
use Filament\PluginServiceProvider;
use FilamentPro\Features\Http\Livewire\DeleteUserForm;
use FilamentPro\Features\Http\Livewire\LogoutOtherBrowserSessionsForm;
use FilamentPro\Features\Http\Livewire\SanctumTokens;
use FilamentPro\Features\Http\Livewire\TwoFactorAuthenticationForm;
use FilamentPro\Features\Http\Livewire\UpdatePasswordForm;
use FilamentPro\Features\Http\Livewire\UpdateProfileInformationForm;
use FilamentPro\Features\Http\Middleware\EnsureAccountIsNotExpired;
use FilamentPro\Features\Http\Middleware\EnsureEmailIsVerified;
use FilamentPro\Features\Pages\APITokenManager;
use FilamentPro\Features\Pages\MyProfile;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;
use FilamentPro\Features\Commands\FeaturesCommand;
use FilamentPro\Features\Http\Livewire\Auth;

class FeaturesServiceProvider extends PluginServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('filament-features')
            ->hasConfigFile()
            ->hasRoute("web")
            ->hasViews()
            ->hasTranslations()
            ->hasMigration('create_filament-features_table')
            ->hasCommand(FeaturesCommand::class);
    }

    public function packageRegistered(): void
    {
        parent::packageRegistered();

        if(Features::enabled(Features::accountExpired())){
            $this->mergeConfig([
                EnsureAccountIsNotExpired::class,
            ], 'filament.middleware.auth');
        }

        if(Features::enabled(Features::emailVerification())){
            $this->mergeConfig([
                EnsureEmailIsVerified::class,
            ], 'filament.middleware.auth');
        }

    }

    public function packageBooted(): void
    {
        parent::packageBooted();

        Livewire::component(Auth\Login::getName(), Auth\Login::class);


        if (Features::enabled(Features::updateProfileInformation())) {
            Livewire::component(UpdateProfileInformationForm::getName(), UpdateProfileInformationForm::class);

            if(Features::options(Features::updateProfileInformation(), 'show_in_user_menu')){
                Filament::serving(function () {
                    Filament::registerUserMenuItems([
                        'account' => UserMenuItem::make()->url(MyProfile::getUrl()),
                    ]);
                });
            }
        }

        if (Features::enabled(Features::updatePasswords())) {
            Livewire::component(UpdatePasswordForm::getName(), UpdatePasswordForm::class);
        }

        if(Features::enabled(Features::twoFactorAuthentication())){
            Livewire::component(TwoFactorAuthenticationForm::getName(), TwoFactorAuthenticationForm::class);
        }

        if (Features::enabled(Features::resetPasswords())) {
            Livewire::component(Auth\ResetPassword::getName(), Auth\ResetPassword::class);
        }

        if (Features::enabled(Features::registration())) {
            Livewire::component(Auth\Register::getName(), Auth\Register::class);
        }

        if (Features::enabled(Features::emailVerification())) {
            Livewire::component(Auth\Verify::getName(), Auth\Verify::class);
        }


        if (Features::enabled(Features::sanctum())) {
        }

        if (Features::enabled(Features::accountDeletion())) {
            Livewire::component(DeleteUserForm::getName(), DeleteUserForm::class);
        }

        if (Features::enabled(Features::browserSessions())) {
            $this->app['router']->pushMiddlewareToGroup('web', \Illuminate\Session\Middleware\AuthenticateSession::class);
            Livewire::component(LogoutOtherBrowserSessionsForm::getName(), LogoutOtherBrowserSessionsForm::class);
        }

        if(Features::enabled(Features::sactum())) {
            Livewire::component(SanctumTokens::getName(), SanctumTokens::class);

            if(Features::options(Features::sactum(), 'show_in_user_menu')){
                Filament::serving(function () {
                    Filament::registerUserMenuItems([
                        'api-tokens' => UserMenuItem::make()->label(__('API Tokens'))->icon('heroicon-o-archive')->url(APITokenManager::getUrl()),
                    ]);
                });
            }

        }
    }

    protected function getPages(): array
    {
        $pages = [];

        if(Features::enabled(Features::updateProfileInformation())) $pages[] = MyProfile::class;

        if(Features::enabled(Features::sactum())) $pages[] = APITokenManager::class;

        return $pages;
    }

    /**
     * Merge config from array.
     */
    protected function mergeConfig(array $config, string $key): void
    {
        $default = $this->app['config']->get($key, []);
        $this->app['config']->set($key, array_merge($config, $default));
    }
}
