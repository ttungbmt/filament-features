<?php

use FilamentPro\Features\Features;

return [
    /*
    |--------------------------------------------------------------------------
    | Auth / User configs
    |--------------------------------------------------------------------------
    | This is the Auth model used by Filament Teams.
    */
    'user_model' => config('auth.providers.users.model', App\Models\User::class),

    'password_rules' => ['min:3'],

    'features' => [

        Features::registration([
            'component' => \FilamentPro\Features\Http\Livewire\Auth\Register::class,

            'redirect_url' => config('filament.home_url', '/')
        ]),

        Features::resetPasswords([
            'component' => \FilamentPro\Features\Http\Livewire\Auth\ResetPassword::class,
        ]),

        Features::emailVerification([
            'component' => \FilamentPro\Features\Http\Livewire\Auth\Verify::class,
        ]),

        Features::updateProfileInformation([
            /*
           | Whether or not to automatically link the My Profile page in the user menu of Filament.
           */
            'show_in_user_menu' => true,
            /*
            | Whether or not to automatically display the My Profile page in the navigation of Filament.
            */
            'show_in_navbar' => false
        ]),

        Features::updatePasswords(),

        Features::twoFactorAuthentication(),

        Features::accountExpired([
            'component' => \FilamentPro\Features\Http\Livewire\Auth\AccountExpired::class,
        ]),

        Features::browserSessions(),

        Features::profilePhotos(),

        Features::accountDeletion(),

        Features::sactum([
            'show_in_user_menu' => true,

            'show_in_navbar' => false,

            'permissions' => ['create', 'read', 'update', 'delete']
        ]),
    ],
];
