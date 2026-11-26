<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\NewsPost;
use App\Models\Product;
use App\Models\TeamMember;
use App\Services\SiteContentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\View\View;

class SiteController extends Controller
{
    public function show(string $locale, ?string $page = null): View
    {
        App::setLocale($locale);

        $page ??= 'home';
        $view = $page === 'home' ? 'welcome' : "site.{$page}";

        $data = [
            'locale' => $locale,
            'page' => $page,
            'site' => app(SiteContentService::class),
        ];

        if ($page === 'products') {
            $data['cmsProducts'] = Product::active()->orderBy('sort_order')->orderBy('id')->get();
        }

        if ($page === 'news') {
            $data['cmsNews'] = NewsPost::published()->latest('published_at')->get();
        }

        if ($page === 'about') {
            $data['cmsTeam'] = TeamMember::orderBy('sort_order')->orderBy('id')->get();
        }

        return view($view, $data);
    }

    public function storeContact(Request $request, string $locale): RedirectResponse
    {
        $countries = config('countries');

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'country' => ['required', 'string', 'in:'.implode(',', array_keys($countries))],
            'phone' => ['required', 'string', 'regex:/^[0-9\\s()\\-]{5,25}$/'],
            'message' => ['required', 'string', 'max:5000'],
            'consent' => ['accepted'],
            'website' => ['nullable', 'max:0'],
        ]);

        $country = $countries[$validated['country']];
        $localPhone = preg_replace('/\\D/', '', $validated['phone']);

        ContactMessage::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'country_code' => $validated['country'],
            'country_name' => $country['name'],
            'phone' => $country['dial'].ltrim($localPhone, '0'),
            'message' => $validated['message'],
        ]);

        return redirect()->route('site.page', ['locale' => $locale, 'page' => 'contact'])
            ->with('status', match ($locale) {
                'en' => 'Your request has been sent. We will contact you soon.',
                'uz' => 'So‘rovingiz yuborildi. Tez orada siz bilan bog‘lanamiz.',
                default => 'Заявка отправлена. Мы скоро свяжемся с вами.',
            });
    }
}
