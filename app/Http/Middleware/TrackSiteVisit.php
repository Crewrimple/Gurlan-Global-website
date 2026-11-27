<?php

namespace App\Http\Middleware;

use App\Models\SiteVisit;
use Closure;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class TrackSiteVisit
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
    }

    public function terminate(Request $request, Response $response): void
    {
        if (
            ! $response->isSuccessful()
            || $request->method() !== 'GET'
            || $request->cookie('ggt_analytics_consent') !== 'accepted'
            || $request->user() !== null
            || preg_match('/bot|crawler|spider|preview|headless/i', (string) $request->userAgent()) === 1
        ) {
            return;
        }

        $visitorId = (string) $request->cookie('ggt_visitor_id');

        if ($visitorId === '') {
            return;
        }

        try {
            SiteVisit::query()->create([
                'visitor_hash' => hash_hmac('sha256', $visitorId, (string) config('app.key')),
                'path' => Str::limit('/'.ltrim($request->path(), '/'), 250),
                'country' => $this->country($request),
                'device' => $this->device($request),
                'browser' => $this->browser($request),
                'referrer_host' => $this->referrerHost($request),
                'viewed_at' => now(),
            ]);
        } catch (QueryException $exception) {
            Log::error('Unable to record site analytics.', ['exception' => $exception]);
        }
    }

    private function country(Request $request): ?string
    {
        $country = strtoupper(trim((string) $request->header('CF-IPCountry')));

        if (preg_match('/^[A-Z]{2}$/', $country) === 1 && $country !== 'XX') {
            return $country;
        }

        return app()->environment('local', 'testing') ? 'UZ' : null;
    }

    private function device(Request $request): string
    {
        $agent = (string) $request->userAgent();

        if (preg_match('/tablet|ipad/i', $agent) === 1) {
            return 'tablet';
        }

        return preg_match('/mobile|android|iphone|ipod/i', $agent) === 1 ? 'mobile' : 'desktop';
    }

    private function browser(Request $request): string
    {
        $agent = (string) $request->userAgent();

        return match (true) {
            str_contains($agent, 'Edg/') => 'Edge',
            str_contains($agent, 'OPR/') || str_contains($agent, 'Opera') => 'Opera',
            str_contains($agent, 'Firefox/') => 'Firefox',
            str_contains($agent, 'SamsungBrowser/') => 'Samsung Internet',
            str_contains($agent, 'Chrome/') => 'Chrome',
            str_contains($agent, 'Safari/') => 'Safari',
            default => 'Other',
        };
    }

    private function referrerHost(Request $request): ?string
    {
        $referer = (string) $request->headers->get('referer');
        $host = parse_url($referer, PHP_URL_HOST);

        if (! is_string($host) || $host === '' || $host === $request->getHost()) {
            return null;
        }

        return Str::lower(Str::limit($host, 191));
    }
}
