<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * @var string[]
     */
    private array $supportedLocales = ['tr', 'en'];

    public function handle(Request $request, Closure $next): Response
    {
        $locale = null;

        if (Auth::check()) {
            $userLocale = Auth::user()->locale ?? null;
            if (is_string($userLocale) && in_array($userLocale, $this->supportedLocales, true)) {
                $locale = $userLocale;
            }
        }

        if (!$locale) {
            $sessionLocale = $request->session()->get('locale');
            if (is_string($sessionLocale) && in_array($sessionLocale, $this->supportedLocales, true)) {
                $locale = $sessionLocale;
            }
        }

        if (!$locale) {
            $preferred = $request->getPreferredLanguage($this->supportedLocales);
            if (is_string($preferred) && in_array($preferred, $this->supportedLocales, true)) {
                $locale = $preferred;
            }
        }

        $locale = $locale ?: config('app.locale', 'en');

        App::setLocale($locale);
        $request->session()->put('locale', $locale);

        return $next($request);
    }
}

