<?php

namespace FilamentPro\Features\Http\Middleware;

use Closure;
use Filament\Facades\Filament;
use FilamentPro\Features\Features;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

class EnsureAccountIsNotExpired
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if ($request->user() && $request->user()->isExpired() && Features::enabled(Features::accountExpired())) {
            Filament::auth()->logout();

            return Redirect::guest(URL::route('filament.account.expired'));
        }

        return $next($request);
    }
}
