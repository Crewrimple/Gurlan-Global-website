<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AnalyticsConsentController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'decision' => ['required', 'in:accepted,declined'],
        ]);

        $response = response()->json(['decision' => $validated['decision']]);
        $secure = $request->isSecure();

        if ($validated['decision'] === 'accepted') {
            $response->cookie('ggt_analytics_consent', 'accepted', 60 * 24 * 365, '/', null, $secure, true, false, 'Lax');
            $response->cookie('ggt_visitor_id', (string) Str::uuid(), 60 * 24 * 365, '/', null, $secure, true, false, 'Lax');
        } else {
            $response->cookie('ggt_analytics_consent', 'declined', 60 * 24 * 180, '/', null, $secure, true, false, 'Lax');
            $response->withoutCookie('ggt_visitor_id');
        }

        return $response;
    }
}
