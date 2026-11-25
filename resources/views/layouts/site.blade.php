@php
    $english = $locale === 'en';
    $uzbek = $locale === 'uz';
    $homeUrl = route('site.page', ['locale' => $locale]);
    $contactUrl = route('site.page', ['locale' => $locale, 'page' => 'contact']);
    $uzumStoreUrl = 'https://uzum.uz/ru/shop/gurlanglobal';
    $uzumStoreLabel = $english ? 'Our products on the Uzum marketplace' : ($uzbek ? 'Mahsulotlarimiz Uzum marketpleysida' : 'Наши товары на маркетплейсе Uzum');
    $mapUrl = 'https://www.google.com/maps/place/Gurlan+Global+Teks/@41.8263463,60.3761645,17z/data=!3m1!4b1!4m6!3m5!1s0x41de3d34acd9eea7:0x3b846a79d9fbb837!8m2!3d41.8263463!4d60.3761645!16s%2Fg%2F11r_9v7gdh';
    $navigation = $uzbek
        ? [
            ['title' => 'Kompaniya haqida', 'page' => 'about'],
            ['title' => 'Ishlab chiqarish', 'page' => 'production'],
            ['title' => 'Mahsulotlar', 'page' => 'products'],
            ['title' => 'Aloqa', 'page' => 'contact'],
            ['title' => 'Yangiliklar', 'page' => 'news'],
        ]
        : ($english
            ? [
            ['title' => 'About', 'page' => 'about'],
            ['title' => 'Production', 'page' => 'production'],
            ['title' => 'Products', 'page' => 'products'],
            ['title' => 'Contacts', 'page' => 'contact'],
            ['title' => 'News', 'page' => 'news'],
            ]
            : [
            ['title' => 'О компании', 'page' => 'about'],
            ['title' => 'Производство', 'page' => 'production'],
            ['title' => 'Продукция', 'page' => 'products'],
            ['title' => 'Контакты', 'page' => 'contact'],
            ['title' => 'Новости', 'page' => 'news'],
            ]);
@endphp
<!DOCTYPE html>
<html lang="{{ $locale }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f4f8f7">
    <title>@yield('title', 'Gurlan Global Teks')</title>
    <link rel="icon" type="image/png" href="{{ asset('gurlan-assets/Gurlan_global-03.png') }}">
    <link rel="stylesheet" href="{{ asset('css/site.css') }}?v={{ filemtime(public_path('css/site.css')) }}">
    <script defer src="{{ asset('js/site.js') }}"></script>
</head>
<body>
    <div class="scroll-progress" data-scroll-progress aria-hidden="true"></div>

    <header @class(['site-header', 'is-transparent' => $page === 'home'])>
        <div class="header-inner">
            <a class="brand" href="{{ $homeUrl }}" aria-label="Gurlan Global Teks">
                <img src="{{ asset('gurlan-assets/Gurlan_global-03.png') }}" alt="Gurlan Global Teks" width="104" height="44">
            </a>

            <nav class="desktop-nav" aria-label="{{ $english ? 'Main navigation' : ($uzbek ? 'Asosiy navigatsiya' : 'Основная навигация') }}">
                @foreach ($navigation as $item)
                    <a href="{{ route('site.page', ['locale' => $locale, 'page' => $item['page']]) }}"
                        @if ($page === $item['page']) aria-current="page" @endif>
                        {{ $item['title'] }}
                    </a>
                @endforeach
            </nav>

            <div class="header-actions">
                <a class="catalog-link" href="{{ $uzumStoreUrl }}" target="_blank" rel="noopener noreferrer" aria-label="{{ $uzumStoreLabel }}">
                    <span>{{ $uzumStoreLabel }}</span>
                    <b>↗</b>
                </a>
                <a class="header-contact" href="{{ $contactUrl }}">{{ $english ? 'Contact us' : ($uzbek ? 'Biz bilan bog‘laning' : 'Связаться с нами') }}</a>
                <a class="phone-icon" href="tel:+998919858707" aria-label="+998 91 985 87 07">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7.1 3.8 9.4 7l-1.6 2a14 14 0 0 0 7.2 7.2l2-1.6 3.2 2.3-.8 3.1a2 2 0 0 1-2.2 1.5A18.2 18.2 0 0 1 2.5 6.8 2 2 0 0 1 4 4.6l3.1-.8Z"/></svg>
                </a>
                <div class="language-switch" aria-label="{{ $english ? 'Language' : ($uzbek ? 'Til' : 'Язык') }}">
                    <a href="{{ route('site.page', ['locale' => 'en', 'page' => $page === 'home' ? null : $page]) }}" lang="en" @if ($english) aria-current="page" @endif>en</a>
                    <a href="{{ route('site.page', ['locale' => 'ru', 'page' => $page === 'home' ? null : $page]) }}" lang="ru" @if ($locale === 'ru') aria-current="page" @endif>ru</a>
                    <a href="{{ route('site.page', ['locale' => 'uz', 'page' => $page === 'home' ? null : $page]) }}" lang="uz" @if ($uzbek) aria-current="page" @endif>uz</a>
                </div>
                <button class="menu-toggle" type="button" aria-label="{{ $english ? 'Open menu' : ($uzbek ? 'Menyuni ochish' : 'Открыть меню') }}" aria-expanded="false" aria-controls="mobile-menu" data-menu-toggle>
                    <span></span><span></span>
                </button>
            </div>
        </div>
    </header>

    <div class="mobile-menu" id="mobile-menu" data-mobile-menu hidden>
        <button class="mobile-menu-close" type="button" aria-label="{{ $english ? 'Close menu' : ($uzbek ? 'Menyuni yopish' : 'Закрыть меню') }}" data-menu-close>×</button>
        <nav aria-label="{{ $english ? 'Mobile navigation' : ($uzbek ? 'Mobil navigatsiya' : 'Мобильная навигация') }}">
            <a href="{{ $homeUrl }}" @if ($page === 'home') aria-current="page" @endif>{{ $english ? 'Home' : ($uzbek ? 'Bosh sahifa' : 'Главная') }}</a>
            @foreach ($navigation as $item)
                <a href="{{ route('site.page', ['locale' => $locale, 'page' => $item['page']]) }}" @if ($page === $item['page']) aria-current="page" @endif>{{ $item['title'] }}</a>
            @endforeach
            <a class="uzum-nav-link" href="{{ $uzumStoreUrl }}" target="_blank" rel="noopener noreferrer">{{ $uzumStoreLabel }} <span aria-hidden="true">↗</span></a>
        </nav>
        <a class="mobile-menu-contact" href="{{ $contactUrl }}">{{ $english ? 'Contact us' : ($uzbek ? 'Biz bilan bog‘laning' : 'Связаться с нами') }} ↗</a>
        <div class="mobile-menu-languages">
            <a href="{{ route('site.page', ['locale' => 'en', 'page' => $page === 'home' ? null : $page]) }}" lang="en" @if ($english) aria-current="page" @endif>en</a>
            <a href="{{ route('site.page', ['locale' => 'ru', 'page' => $page === 'home' ? null : $page]) }}" lang="ru" @if ($locale === 'ru') aria-current="page" @endif>ru</a>
            <a href="{{ route('site.page', ['locale' => 'uz', 'page' => $page === 'home' ? null : $page]) }}" lang="uz" @if ($uzbek) aria-current="page" @endif>uz</a>
        </div>
    </div>

    <main>
        @yield('content')
    </main>

    @if (in_array($page, ['home', 'about', 'production'], true))
        <section class="partner-cta">
            <div class="partner-cta-inner">
                <div>
                    <h2>{{ $english ? 'WE VALUE EVERY ONE OF OUR PARTNERS' : ($uzbek ? 'BIZ HAR BIR HAMKORIMIZNI QADRLAYMIZ' : 'МЫ ЦЕНИМ КАЖДОГО НАШЕГО ПАРТНЁРА') }}</h2>
                    <div class="partner-cta-actions">
                        <a href="{{ $contactUrl }}">{{ $english ? 'Contact us' : ($uzbek ? 'Biz bilan bog‘laning' : 'Связаться с нами') }} <span>↗</span></a>
                        <a href="{{ $mapUrl }}" target="_blank" rel="noopener noreferrer">{{ $english ? 'Location' : ($uzbek ? 'Manzil' : 'Локация') }} <span>↗</span></a>
                    </div>
                </div>
                <a class="partner-phone" href="tel:+998919858707">
                    <span>+998 91 985 87 07</span>
                    <small>{{ $english ? 'Information Desk:' : ($uzbek ? 'Ma’lumot uchun:' : 'Справочная:') }}</small>
                </a>
            </div>
        </section>
    @endif

    <footer class="site-footer">
        <div class="footer-grid">
            <div class="footer-column">
                <h2>{{ $english ? 'Menu' : ($uzbek ? 'Menyu' : 'Меню') }}</h2>
                <a href="{{ $homeUrl }}">{{ $english ? 'Home' : ($uzbek ? 'Bosh sahifa' : 'Главная') }}</a>
                @foreach ($navigation as $item)
                    <a href="{{ route('site.page', ['locale' => $locale, 'page' => $item['page']]) }}">{{ $item['title'] }}</a>
                @endforeach
            </div>
            <div class="footer-column">
                <h2>{{ $english ? 'Contacts' : ($uzbek ? 'Aloqa' : 'Контакты') }}</h2>
                <a href="tel:+998919858707">+998 91 985 87 07</a>
                <a href="mailto:gurlanglobal@gmail.com">gurlanglobal@gmail.com</a>
                <a href="https://t.me/ggt_inc" target="_blank" rel="noopener noreferrer">Telegram</a>
                <a href="https://wa.me/998919858707" target="_blank" rel="noopener noreferrer">Whatsapp</a>
                <a href="https://www.instagram.com/ggt_textile/" target="_blank" rel="noopener noreferrer">Instagram</a>
            </div>
            <div class="footer-column footer-address">
                <h2>{{ $english ? 'Address' : ($uzbek ? 'Manzil' : 'Адрес') }}</h2>
                <p>{{ $english ? 'Republic of Uzbekistan, Khorezm Region, Gurlan District, Mustaqillik Street, 5' : ($uzbek ? 'O‘zbekiston Respublikasi, Xorazm viloyati, Gurlan tumani, Mustaqillik ko‘chasi, 5' : 'Республика Узбекистан, Хорезмская область, Гурленский район, ул. Мустакиллик, 5') }}</p>
                <a href="{{ $mapUrl }}" target="_blank" rel="noopener noreferrer">{{ $english ? 'View on map' : ($uzbek ? 'Xaritada ko‘rish' : 'Посмотреть на карте') }} ↗</a>
            </div>
        </div>
        <div class="footer-bottom">
            <a class="footer-catalog" href="{{ route('site.page', ['locale' => $locale, 'page' => 'products']) }}">{{ $english ? 'Product range' : ($uzbek ? 'Mahsulotlar assortimenti' : 'Ассортимент продукции') }} <span>↗</span></a>
            <div class="footer-copyright">
                {{ $english ? '© 2026 GURLAN GLOBAL TEKS. All rights reserved.' : ($uzbek ? '© 2026 GURLAN GLOBAL TEKS. Barcha huquqlar himoyalangan.' : '© 2026 GURLAN GLOBAL TEKS. Все права защищены.') }}
            </div>
            <a href="{{ $contactUrl }}">{{ $english ? 'Order products' : ($uzbek ? 'Mahsulotlarga buyurtma berish' : 'Заказать продукцию') }} ↗</a>
        </div>
    </footer>
</body>
</html>
