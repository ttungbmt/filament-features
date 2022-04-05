<?php
namespace FilamentPro\Features\Traits;

use FilamentPro\Features\Features;

trait HasFeatures
{
    public function initializeHasFeatures()
    {
        if(Features::enabled(Features::accountExpired()) && !in_array('expires_at', $this->fillable)){
            $this->fillable[] = 'expires_at';
        }
    }

    /**
     * Check whether the account is expired.
     */
    public function isExpired(): bool
    {
        return $this->expires_at !== null && now()->gt($this->expires_at);
    }


    /**
     * Extend the expiry date.
     */
    public function extendExiryDay(): void
    {
        $this->update([
            'expires_at' => now()->addMonths(1)->endOfDay(),
        ]);
    }
}
