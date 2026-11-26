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
