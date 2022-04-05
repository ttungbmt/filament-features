<?php

namespace FilamentPro\Features;

class Features
{
    /**
     * Determine if the given feature is enabled.
     *
     * @param  string  $feature
     * @return bool
     */
    public static function enabled(string $feature): bool
    {
        return in_array($feature, config('filament-features.features', []));
    }

    public static function options(string $feature, string $path, $default = null)
    {
        return config('filament-features.features-options.'.$feature.'.'.$path, $default);
    }


    public static function setFeature($feature, array $options)
    {
        if (! empty($options)) {
            config(['filament-features.features-options.'.$feature => $options]);
        }

        return $feature;
    }


    /**
     * Enable the registration feature.
     *
     * @return string
     */
    public static function registration(array $options = [])
    {
        return self::setFeature('registration', $options);
    }

    /**
     * Enable the password reset feature.
     *
     * @return string
     */
    public static function resetPasswords(array $options = [])
    {
        return self::setFeature('reset-passwords', $options);
    }

    /**
     * Enable the email verification feature.
     *
     * @return string
     */
    public static function emailVerification(array $options = [])
    {
        return self::setFeature('email-verification', $options);
    }

    /**
     * Enable the update profile information feature.
     *
     * @return string
     */
    public static function updateProfileInformation(array $options = [])
    {
        return self::setFeature('update-profile-information', $options);
    }

    /**
     * Enable the update password feature.
     *
     * @return string
     */
    public static function updatePasswords(array $options = [])
    {
        return self::setFeature('update-passwords', $options);
    }

    /**
     * Enable the update sanctum feature.
     *
     * @return string
     */
    public static function sanctum(array $options = [])
    {
        return self::setFeature('sanctum', $options);
    }


    /**
     * Enable the two factor authentication feature.
     *
     * @param  array  $options
     * @return string
     */
    public static function twoFactorAuthentication(array $options = []): string
    {
        return self::setFeature('two-factor-authentication', $options);
    }

    public static function accountExpired(array $options = []): string
    {
        return self::setFeature('account-expiry', $options);
    }

    /**
     * Enable the profile photo upload feature.
     *
     * @return string
     */
    public static function profilePhotos(array $options = []): string
    {
        return self::setFeature('profile-photos', $options);
    }

    /**
     * Enable the account deletion feature.
     *
     * @return string
     */
    public static function accountDeletion(array $options = []): string
    {
        return self::setFeature('account-deletion', $options);
    }


    public static function browserSessions(array $options = []): string
    {
        return self::setFeature('browser-sessions', $options);
    }

    /**
     * Enable the API feature.
     *
     * @return string
     */
    public static function sactum(array $options = []): string
    {
        return self::setFeature('sactum', $options);
    }
}
