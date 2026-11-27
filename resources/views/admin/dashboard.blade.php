@extends('admin.layouts.admin')

@section('title', 'Панель управления')
@section('content')
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div><p class="admin-kicker">Добро пожаловать</p><h1 class="mt-1 text-3xl font-semibold">Панель управления</h1><p class="admin-page-description">Все основные изменения сайта собраны в одном месте.</p></div>
    </div>
    <div class="mt-8 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        @foreach ([['Продукты', $productsCount, 'admin.products.index', '◇'], ['Новости', $newsCount, 'admin.news.index', '▤'], ['Команда', $teamCount, 'admin.team.index', '◎'], ['Новые заявки', $messagesCount, 'admin.messages.index', '✉']] as [$label, $count, $route, $icon])
            <a class="admin-stat-card" href="{{ route($route) }}">
                <span class="admin-stat-icon">{{ $icon }}</span>
                <p class="text-sm text-stone-500">{{ $label }}</p><strong class="mt-2 block text-3xl">{{ $count }}</strong>
            </a>
        @endforeach
    </div>

    <section class="admin-analytics-section">
        <div class="admin-section-heading">
            <div>
                <p class="admin-kicker">Аналитика сайта</p>
                <h2 class="text-xl font-semibold">Посетители и просмотры</h2>
            </div>
            <span>Последние 30 дней</span>
        </div>
        <div class="admin-analytics-stats">
            <article><span>Уникальные посетители</span><strong>{{ number_format($visitors, 0, '.', ' ') }}</strong><small>за 30 дней</small></article>
            <article><span>Просмотры страниц</span><strong>{{ number_format($pageViews, 0, '.', ' ') }}</strong><small>за 30 дней</small></article>
            <article><span>Посетители сегодня</span><strong>{{ number_format($todayVisitors, 0, '.', ' ') }}</strong><small>{{ number_format($todayPageViews, 0, '.', ' ') }} просмотров</small></article>
        </div>
        <div class="admin-analytics-layout">
            <div class="admin-analytics-card">
                <h3>Просмотры за 7 дней</h3>
                <div class="admin-analytics-chart">
                    @php($maximum = max(1, $dailyVisits->max('total')))
                    @foreach ($dailyVisits as $day)
                        <div class="admin-chart-column" title="{{ $day['date'] }}: {{ $day['total'] }}">
                            <span style="height: {{ max(5, ($day['total'] / $maximum) * 100) }}%"></span>
                            <small>{{ $day['label'] }}</small>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="admin-analytics-card">
                <h3>Страны</h3>
                @forelse ($topCountries as $country)
                    <div class="admin-analytics-row">
                        <span class="admin-country"><i aria-hidden="true">{{ $country->flag }}</i>{{ $country->name }}</span>
                        <b>{{ $country->total }}</b>
                    </div>
                @empty
                    <p class="admin-analytics-empty">Пока нет данных о стране. На Cloudflare они появятся автоматически.</p>
                @endforelse
            </div>
        </div>
        <div class="admin-analytics-layout is-bottom">
            <div class="admin-analytics-card">
                <h3>Популярные страницы</h3>
                @forelse ($topPages as $page)
                    <div class="admin-analytics-row"><span>{{ $page->path }}</span><b>{{ $page->total }}</b></div>
                @empty
                    <p class="admin-analytics-empty">Просмотры появятся после согласия посетителя.</p>
                @endforelse
            </div>
            <div class="admin-analytics-card">
                <h3>Устройства</h3>
                @forelse ($devices as $device)
                    <div class="admin-analytics-row">
                        <span>{{ match ($device->device) { 'mobile' => 'Телефон', 'tablet' => 'Планшет', default => 'Компьютер' } }}</span>
                        <b>{{ $device->total }}</b>
                    </div>
                @empty
                    <p class="admin-analytics-empty">Данных пока нет.</p>
                @endforelse
            </div>
        </div>
    </section>

    <div class="mt-6 rounded-2xl border border-stone-200 bg-white p-6">
        <div class="admin-section-heading"><div><p class="admin-kicker">Быстрый доступ</p><h2 class="text-xl font-semibold">Что можно изменить</h2></div><span>RU · EN · UZ</span></div>
        <div class="admin-quick-grid">
            <a href="{{ route('admin.content.index') }}"><b>Aa</b><div><strong>Тексты, меню и SEO</strong><span>Заголовки, описания и кнопки</span></div><i>→</i></a>
            <a href="{{ route('admin.media.index') }}"><b>▧</b><div><strong>Изображения и видео</strong><span>Логотип, слайды и крупные фото</span></div><i>→</i></a>
            <a href="{{ route('admin.settings.edit') }}"><b>⌖</b><div><strong>Контакты и карта</strong><span>Телефон, соцсети, адрес и ссылки</span></div><i>→</i></a>
            <a href="{{ route('admin.products.index') }}"><b>◇</b><div><strong>Каталог продукции</strong><span>Категории, названия и фотографии</span></div><i>→</i></a>
        </div>
    </div>
@endsection
