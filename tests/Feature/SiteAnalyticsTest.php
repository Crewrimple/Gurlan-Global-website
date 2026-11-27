<?php

use App\Http\Middleware\TrackSiteVisit;
use App\Models\SiteVisit;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

it('renders the analytics consent banner on public pages', function () {
    $this->get('/uz')
        ->assertOk()
        ->assertSee('data-analytics-consent', false)
        ->assertSee('Saytda cookie fayllardan foydalanishga ruxsat berasizmi?')
        ->assertSee('Sozlash')
        ->assertSee('Qabul qilish')
        ->assertSee(route('site.analytics.consent'), false);
});

it('stores the analytics decision in protected cookies', function () {
    $this->postJson(route('site.analytics.consent'), ['decision' => 'accepted'])
        ->assertOk()
        ->assertCookie('ggt_analytics_consent')
        ->assertCookie('ggt_visitor_id');

    $this->postJson(route('site.analytics.consent'), ['decision' => 'invalid'])
        ->assertUnprocessable()
        ->assertJsonValidationErrors('decision');
});

it('records an anonymous consented page visit without storing the raw visitor identifier', function () {
    $request = Request::create('/uz/products', 'GET');
    $request->cookies->set('ggt_analytics_consent', 'accepted');
    $request->cookies->set('ggt_visitor_id', 'private-visitor-id');
    $request->headers->set('CF-IPCountry', 'UZ');
    $request->headers->set('User-Agent', 'Mozilla/5.0 (Windows NT 10.0) Chrome/124 Safari/537.36');
    $request->headers->set('Referer', 'https://google.com/search?q=gurlan');

    (new TrackSiteVisit)->terminate($request, new Response('', 200));

    $this->assertDatabaseHas('site_visits', [
        'path' => '/uz/products',
        'country' => 'UZ',
        'device' => 'desktop',
        'browser' => 'Chrome',
        'referrer_host' => 'google.com',
    ]);

    expect(SiteVisit::query()->sole()->visitor_hash)
        ->not->toBe('private-visitor-id')
        ->toHaveLength(64);
});

it('does not record declined visits, bots, or failed responses', function () {
    $request = Request::create('/uz', 'GET');
    $request->cookies->set('ggt_analytics_consent', 'declined');
    $request->cookies->set('ggt_visitor_id', 'visitor');
    (new TrackSiteVisit)->terminate($request, new Response('', 200));

    $request->cookies->set('ggt_analytics_consent', 'accepted');
    $request->headers->set('User-Agent', 'Googlebot');
    (new TrackSiteVisit)->terminate($request, new Response('', 200));

    $request->headers->set('User-Agent', 'Mozilla/5.0');
    (new TrackSiteVisit)->terminate($request, new Response('', 500));

    expect(SiteVisit::query()->count())->toBe(0);
});

it('uses Uzbekistan as the development-only fallback country', function () {
    config()->set('app.env', 'local');
    $request = Request::create('/ru', 'GET', server: ['REMOTE_ADDR' => '127.0.0.1']);
    $request->cookies->set('ggt_analytics_consent', 'accepted');
    $request->cookies->set('ggt_visitor_id', 'local-visitor');
    $request->headers->set('User-Agent', 'Mozilla/5.0 Chrome/124');

    (new TrackSiteVisit)->terminate($request, new Response('', 200));

    $this->assertDatabaseHas('site_visits', ['country' => 'UZ']);
});

it('shows anonymous analytics totals on the admin dashboard', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $visitorHash = str_repeat('a', 64);

    SiteVisit::query()->create([
        'visitor_hash' => $visitorHash,
        'path' => '/uz/products',
        'country' => 'UZ',
        'device' => 'mobile',
        'browser' => 'Chrome',
        'viewed_at' => now(),
    ]);
    SiteVisit::query()->create([
        'visitor_hash' => $visitorHash,
        'path' => '/uz/contact',
        'country' => 'UZ',
        'device' => 'mobile',
        'browser' => 'Chrome',
        'viewed_at' => now(),
    ]);

    $this->actingAs($admin)
        ->get(route('admin.dashboard'))
        ->assertOk()
        ->assertSee('Аналитика сайта')
        ->assertSee('Уникальные посетители')
        ->assertSee('/uz/products')
        ->assertSee('Узбекистан');
});
