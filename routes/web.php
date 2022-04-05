<?php

use FilamentPro\Features\Features;
use FilamentPro\Features\Http\Controllers\EmailVerificationController;

Route::domain(config('filament.domain'))
    ->middleware(config('filament.middleware.base'))
    ->prefix(config('filament.path'))
    ->group(function () {
        if (Features::enabled(Features::registration())) {
            Route::get('/register', Features::options(Features::registration(),'component'))->name('register');
        }

        if (Features::enabled(Features::resetPasswords())) {
            Route::get('/password/reset', Features::options(Features::resetPasswords(),'component'))->name('password.request');
            Route::get('/password/reset/{token}', Features::options(Features::resetPasswords(),'component'))->name('password.reset');
        }

        if (Features::enabled(Features::accountExpired())) {
            Route::get('/expired', Features::options(Features::accountExpired(),'component'))->name('account.expired');
        }

        if (Features::enabled(Features::emailVerification())) {
            Route::get('email/verify', Features::options(Features::emailVerification(),'component'))
                ->middleware('throttle:6,1')
                ->name('verification.notice');

            Route::get('email/verify/{id}/{hash}', [EmailVerificationController::class, '__invoke',])
                ->middleware('signed')
                ->name('verification.verify');
        }
    });
