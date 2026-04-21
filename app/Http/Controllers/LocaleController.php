<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;

class LocaleController extends Controller
{
    /**
     * @var string[]
     */
    private array $supportedLocales = ['tr', 'en'];

    public function update(Request $request, string $locale): RedirectResponse
    {
        abort_unless(in_array($locale, $this->supportedLocales, true), 404);

        App::setLocale($locale);
        $request->session()->put('locale', $locale);

        $user = $request->user();
        if ($user && Schema::hasColumn('users', 'locale')) {
            $user->forceFill(['locale' => $locale])->save();
        }

        return redirect()->back();
    }
}

