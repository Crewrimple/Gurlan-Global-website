<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\View\View;

class SiteController extends Controller
{
    public function show(string $locale, ?string $page = null): View
    {
        App::setLocale($locale);

        $page ??= 'home';
        $view = $page === 'home' ? 'welcome' : "site.{$page}";

        return view($view, [
            'locale' => $locale,
            'page' => $page,
        ]);
    }
}
