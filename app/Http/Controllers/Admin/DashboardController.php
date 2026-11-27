<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\NewsPost;
use App\Models\Product;
use App\Models\SiteVisit;
use App\Models\TeamMember;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $periodStart = now()->subDays(29)->startOfDay();
        $visits = SiteVisit::query()->where('viewed_at', '>=', $periodStart);
        $dailyVisits = $visits->clone()
            ->selectRaw('DATE(viewed_at) as visit_date, COUNT(*) as total')
            ->groupByRaw('DATE(viewed_at)')
            ->orderByRaw('DATE(viewed_at)')
            ->pluck('total', 'visit_date');

        return view('admin.dashboard', [
            'productsCount' => Product::count(),
            'newsCount' => NewsPost::count(),
            'teamCount' => TeamMember::count(),
            'messagesCount' => ContactMessage::where('is_read', false)->count(),
            'pageViews' => $visits->clone()->count(),
            'visitors' => $visits->clone()->distinct('visitor_hash')->count('visitor_hash'),
            'todayPageViews' => SiteVisit::query()->whereDate('viewed_at', today())->count(),
            'todayVisitors' => SiteVisit::query()->whereDate('viewed_at', today())->distinct('visitor_hash')->count('visitor_hash'),
            'dailyVisits' => $this->completeDailySeries($dailyVisits),
            'topCountries' => $visits->clone()
                ->whereNotNull('country')
                ->selectRaw('country, COUNT(*) as total')
                ->groupBy('country')
                ->orderByDesc('total')
                ->limit(6)
                ->get()
                ->map(function (object $country): object {
                    $country->name = $this->countryName($country->country);
                    $country->flag = $this->countryFlag($country->country);

                    return $country;
                }),
            'topPages' => $visits->clone()
                ->selectRaw('path, COUNT(*) as total')
                ->groupBy('path')
                ->orderByDesc('total')
                ->limit(5)
                ->get(),
            'devices' => $visits->clone()
                ->selectRaw('device, COUNT(*) as total')
                ->groupBy('device')
                ->orderByDesc('total')
                ->get(),
        ]);
    }

    private function completeDailySeries(Collection $dailyVisits): Collection
    {
        return collect(range(0, 6))
            ->reverse()
            ->map(function (int $daysAgo) use ($dailyVisits): array {
                $date = now()->subDays($daysAgo);

                return [
                    'label' => Str::ucfirst($date->locale('ru')->isoFormat('dd')),
                    'date' => $date->toDateString(),
                    'total' => (int) $dailyVisits->get($date->toDateString(), 0),
                ];
            })
            ->values();
    }

    private function countryName(string $code): string
    {
        return match (strtoupper($code)) {
            'UZ' => 'Узбекистан',
            'RU' => 'Россия',
            'KZ' => 'Казахстан',
            'KG' => 'Кыргызстан',
            'TJ' => 'Таджикистан',
            'TM' => 'Туркменистан',
            'AZ' => 'Азербайджан',
            'UA' => 'Украина',
            'BY' => 'Беларусь',
            'TR' => 'Турция',
            'AE' => 'ОАЭ',
            'CN' => 'Китай',
            'IN' => 'Индия',
            'PK' => 'Пакистан',
            'IR' => 'Иран',
            'JP' => 'Япония',
            'KR' => 'Южная Корея',
            'US' => 'США',
            'GB' => 'Великобритания',
            'DE' => 'Германия',
            'FR' => 'Франция',
            'IT' => 'Италия',
            'ES' => 'Испания',
            'NL' => 'Нидерланды',
            'PL' => 'Польша',
            'CA' => 'Канада',
            'AU' => 'Австралия',
            default => strtoupper($code),
        };
    }

    private function countryFlag(string $code): string
    {
        $letters = str_split(strtoupper($code));

        if (count($letters) !== 2) {
            return '🌐';
        }

        return implode('', array_map(
            fn (string $letter): string => mb_chr(ord($letter) - 65 + 127462),
            $letters,
        ));
    }
}
