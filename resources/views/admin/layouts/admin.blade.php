<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Админ-панель') — Gurlan Global</title>
    <link rel="icon" type="image/png" href="{{ asset('gurlan-assets/Gurlan_global-03.png') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body class="admin-body">
    <div class="admin-shell">
        <aside class="admin-sidebar">
            <a class="admin-brand" href="{{ route('admin.dashboard') }}">
                <span class="admin-brand-mark"><img src="{{ asset('gurlan-assets/Gurlan_global-03.png') }}" alt=""></span>
                <span><strong>Gurlan Admin</strong><small>Управление сайтом</small></span>
            </a>
            <nav aria-label="Основная навигация админ-панели">
                @foreach ([
                    'Обзор' => [['admin.dashboard', 'Панель', '▦']],
                    'Контент' => [
                        ['admin.content.index', 'Тексты и SEO', 'Aa'],
                        ['admin.media.index', 'Медиафайлы', '▧'],
                        ['admin.team.index', 'Команда', '◎'],
                    ],
                    'Материалы' => [
                        ['admin.products.index', 'Продукция', '◇'],
                        ['admin.news.index', 'Новости', '▤'],
                    ],
                    'Сайт' => [
                        ['admin.settings.edit', 'Контакты и карта', '⌖'],
                        ['admin.messages.index', 'Заявки', '✉'],
                    ],
                ] as $section => $items)
                    <div class="admin-nav-section">
                        <p>{{ $section }}</p>
                        @foreach ($items as [$route, $label, $icon])
                            <a class="{{ request()->routeIs($route) ? 'is-active' : '' }}" href="{{ route($route) }}">
                                <span aria-hidden="true">{{ $icon }}</span>{{ $label }}
                            </a>
                        @endforeach
                    </div>
                @endforeach
            </nav>
            <div class="admin-user">
                <div class="admin-avatar">{{ mb_strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}</div>
                <div><strong>{{ auth()->user()->name }}</strong><small>{{ auth()->user()->email }}</small></div>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" aria-label="Выйти" title="Выйти">↗</button>
                </form>
            </div>
        </aside>
        <main class="admin-main">
            <header class="admin-topbar">
                <div>
                    <span class="admin-status-dot"></span>
                    Сайт доступен
                </div>
                <a href="{{ route('site.page', ['locale' => 'ru']) }}" target="_blank" rel="noopener">Открыть сайт <span>↗</span></a>
            </header>
            <div class="admin-content">
                @if (session('status'))
                    <div class="mb-5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-900" role="status">{{ session('status') }}</div>
                @endif
                @if ($errors->any())
                    <div class="mb-5 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-900" role="alert">
                        <ul class="list-disc space-y-1 pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
