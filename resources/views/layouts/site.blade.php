@php
    $english = $locale === 'en';
    $uzbek = $locale === 'uz';
    $homeUrl = route('site.page', ['locale' => $locale]);
    $contactUrl = route('site.page', ['locale' => $locale, 'page' => 'contact']);
    $uzumStoreUrl = $site->setting('uzum');
    $uzumStoreLabel = $site->text($locale, 'common', 'uzum_label');
    $mapUrl = $site->setting('map');
    $navigation = [
        ['title' => $site->text($locale, 'common', 'about_nav'), 'page' => 'about'],
        ['title' => $site->text($locale, 'common', 'production_nav'), 'page' => 'production'],
        ['title' => $site->text($locale, 'common', 'products_nav'), 'page' => 'products'],
        ['title' => $site->text($locale, 'common', 'contact_nav'), 'page' => 'contact'],
        ['title' => $site->text($locale, 'common', 'news_nav'), 'page' => 'news'],
    ];
@endphp
<!DOCTYPE html>
<html lang="{{ $locale }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f4f8f7">
    <meta name="description" content="{{ $site->text($locale, 'common', 'meta_description') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', $site->text($locale, 'common', 'home_title'))</title>
    <link rel="icon" type="image/png" href="{{ $site->media('logo') }}">
    <link rel="stylesheet" href="{{ asset('css/site.css') }}?v={{ filemtime(public_path('css/site.css')) }}">
    <script defer src="{{ asset('js/site.js') }}"></script>
</head>
<body>
    <div class="scroll-progress" data-scroll-progress aria-hidden="true"></div>

    <header @class(['site-header', 'is-transparent' => $page === 'home'])>
        <div class="header-inner">
            <a class="brand" href="{{ $homeUrl }}" aria-label="Gurlan Global Teks">
                <img src="{{ $site->media('logo') }}" alt="Gurlan Global Teks" width="104" height="44">
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
                <a class="header-contact" href="{{ $contactUrl }}">{{ $site->text($locale, 'common', 'contact_cta') }}</a>
                <a class="phone-icon" href="tel:{{ $site->setting('phone') }}" aria-label="{{ $site->setting('phone') }}">
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

    @if (! in_array(request()->cookie('ggt_analytics_consent'), ['accepted', 'declined'], true))
        <aside class="analytics-consent" data-analytics-consent data-endpoint="{{ route('site.analytics.consent') }}" aria-label="{{ $english ? 'Analytics preference' : ($uzbek ? 'Analitika sozlamalari' : 'Настройка аналитики') }}">
            <div>
                <strong>{{ $english ? 'Do you allow cookies on this site?' : ($uzbek ? 'Saytda cookie fayllardan foydalanishga ruxsat berasizmi?' : 'Разрешить использование файлов cookie?') }}</strong>
                <p>{{ $english ? 'We use essential cookies to keep the site working and optional cookies to count visits, pages viewed, device type and approximate country — without names or contact details.' : ($uzbek ? 'Sayt ishlashi uchun zarur cookie fayllar hamda tashriflar, ko‘rilgan sahifalar, qurilma turi va taxminiy mamlakatni hisoblash uchun ixtiyoriy cookie fayllardan foydalanamiz — ism va aloqa ma’lumotlari saqlanmaydi.' : 'Мы используем необходимые cookie для работы сайта и дополнительные cookie для подсчёта посещений, просмотренных страниц, типа устройства и примерной страны — без имени и контактных данных.') }}</p>
            </div>
            <div class="analytics-consent-actions">
                <button type="button" data-analytics-settings aria-expanded="false">{{ $english ? 'Settings' : ($uzbek ? 'Sozlash' : 'Настроить') }}</button>
                <button type="button" data-analytics-accept>{{ $english ? 'Accept' : ($uzbek ? 'Qabul qilish' : 'Принять') }}</button>
            </div>
            <div class="analytics-consent-settings" data-analytics-settings-panel hidden>
                <label>
                    <span>{{ $english ? 'Visit and device statistics' : ($uzbek ? 'Tashrif va qurilma statistikasi' : 'Статистика посещений и устройств') }}</span>
                    <input type="checkbox" checked data-analytics-option>
                </label>
                <button type="button" data-analytics-save>{{ $english ? 'Save selection' : ($uzbek ? 'Tanlovni saqlash' : 'Сохранить выбор') }}</button>
            </div>
        </aside>
    @endif

    <aside class="site-assistant" data-site-assistant data-endpoint="{{ route('site.assistant.store', ['locale' => $locale]) }}">
        <button class="assistant-toggle" type="button" data-assistant-toggle aria-expanded="false" aria-controls="site-assistant-panel">
            <span class="assistant-logo">
                <img src="{{ $site->media('logo') }}" alt="" width="34" height="34">
            </span>
            <span class="assistant-toggle-copy">
                <strong>GGT AI</strong>
                <small>{{ $english ? 'Assistant · Online' : ($uzbek ? 'Yordamchi · Onlayn' : 'Помощник · Онлайн') }}</small>
            </span>
        </button>

        <section class="assistant-panel" id="site-assistant-panel" data-assistant-panel role="dialog" aria-labelledby="site-assistant-title" hidden>
            <header class="assistant-panel-header">
                <div class="assistant-brand-mark" aria-hidden="true">
                    <span>AI</span>
                </div>
                <div class="assistant-header-copy">
                    <span>GURLAN GLOBAL TEKS</span>
                    <strong id="site-assistant-title">GGT AI · {{ $english ? 'Personal assistant' : ($uzbek ? 'Sizning yordamchingiz' : 'Ваш персональный помощник') }}</strong>
                    <small><i></i>{{ $english ? 'Online' : ($uzbek ? 'Onlayn' : 'Онлайн') }}</small>
                </div>
                <button type="button" data-assistant-close aria-label="{{ $english ? 'Close assistant' : ($uzbek ? 'Yordamchini yopish' : 'Закрыть помощник') }}">×</button>
            </header>
            <div class="assistant-messages" data-assistant-messages aria-live="polite">
                <div class="assistant-welcome">
                    <div class="assistant-welcome-icon">
                        <img src="{{ $site->media('logo') }}" alt="" width="54" height="54">
                    </div>
                    <span>{{ $english ? 'Welcome to Gurlan Global Teks' : ($uzbek ? 'Gurlan Global Teksga xush kelibsiz' : 'Добро пожаловать в Gurlan Global Teks') }}</span>
                    <h3>{{ $english ? 'How can I help you today?' : ($uzbek ? 'Bugun sizga qanday yordam bera olaman?' : 'Чем я могу помочь вам сегодня?') }}</h3>
                    <p>{{ $english ? 'I know our products, production process, capacity, certificates and contact details.' : ($uzbek ? 'Men mahsulotlar, ishlab chiqarish jarayoni, quvvatlar, sertifikatlar va aloqa ma’lumotlari bo‘yicha javob bera olaman.' : 'Я помогу с ассортиментом, производством, мощностями, сертификатами и контактами.') }}</p>
                </div>
            </div>
            <div class="assistant-suggestions" data-assistant-suggestions>
                @php
                    $assistantSuggestions = $english
                        ? ['Tell me about the company', 'What do you manufacture?', 'Production under our brand', 'Lead times', 'How can I contact you?']
                        : ($uzbek
                            ? ['Kompaniya haqida ma’lumot', 'Nimalar ishlab chiqarasiz?', 'Bizning brend uchun', 'Buyurtma muddati', 'Qanday bog‘lanish mumkin?']
                            : ['О компании', 'Какую продукцию вы производите?', 'Производство под нашим брендом', 'Сроки заказа', 'Как с вами связаться?']);
                @endphp
                @foreach ($assistantSuggestions as $suggestion)
                    <button type="button" data-assistant-question="{{ $suggestion }}">{{ $suggestion }}</button>
                @endforeach
            </div>
            <form class="assistant-form" data-assistant-form>
                <input type="text" name="website" class="assistant-website" tabindex="-1" autocomplete="off" aria-hidden="true">
                <input type="text" name="question" maxlength="1000" minlength="2" required
                    placeholder="{{ $english ? 'Enter your question…' : ($uzbek ? 'Savolingizni yozing…' : 'Введите ваш вопрос…') }}"
                    aria-label="{{ $english ? 'Your question' : ($uzbek ? 'Savolingiz' : 'Ваш вопрос') }}"
                    autocomplete="off">
                <button type="submit" aria-label="{{ $english ? 'Send' : ($uzbek ? 'Yuborish' : 'Отправить') }}">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m4 4 17 8-17 8 3-8-3-8Zm3 8h14"/></svg>
                </button>
            </form>
            <small class="assistant-note">{{ $english ? 'AI answers may be inaccurate. Confirm important details with our team.' : ($uzbek ? 'Sun’iy intellekt javoblarida xato bo‘lishi mumkin. Muhim ma’lumotlarni jamoamiz bilan aniqlashtiring.' : 'Ответы ИИ могут содержать неточности. Важные детали уточняйте у нашей команды.') }}</small>
        </section>
    </aside>

    @if (in_array($page, ['home', 'about', 'production'], true))
        <section class="partner-cta">
            <div class="partner-cta-inner">
                <div>
                    <h2>{{ $site->text($locale, 'common', 'partner_heading') }}</h2>
                    <div class="partner-cta-actions">
                        <a href="{{ $contactUrl }}">{{ $english ? 'Contact us' : ($uzbek ? 'Biz bilan bog‘laning' : 'Связаться с нами') }} <span>↗</span></a>
                        <a href="{{ $mapUrl }}" target="_blank" rel="noopener noreferrer">{{ $english ? 'Location' : ($uzbek ? 'Manzil' : 'Локация') }} <span>↗</span></a>
                    </div>
                </div>
                <a class="partner-phone" href="tel:{{ $site->setting('phone') }}">
                    <span>{{ $site->setting('phone') }}</span>
                    <small>{{ $site->text($locale, 'common', 'information_desk') }}</small>
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
                <a href="tel:{{ $site->setting('phone') }}">{{ $site->setting('phone') }}</a>
                <a href="mailto:{{ $site->setting('email') }}">{{ $site->setting('email') }}</a>
                <a href="{{ $site->setting('telegram') }}" target="_blank" rel="noopener noreferrer">Telegram</a>
                <a href="{{ $site->setting('whatsapp') }}" target="_blank" rel="noopener noreferrer">Whatsapp</a>
                <a href="{{ $site->setting('instagram') }}" target="_blank" rel="noopener noreferrer">Instagram</a>
            </div>
            <div class="footer-column footer-address">
                <h2>{{ $english ? 'Address' : ($uzbek ? 'Manzil' : 'Адрес') }}</h2>
                <p>{{ $site->setting('address_'.$locale) }}</p>
                <a href="{{ $mapUrl }}" target="_blank" rel="noopener noreferrer">{{ $english ? 'View on map' : ($uzbek ? 'Xaritada ko‘rish' : 'Посмотреть на карте') }} ↗</a>
            </div>
        </div>
        <div class="footer-bottom">
            <a class="footer-catalog" href="{{ route('site.page', ['locale' => $locale, 'page' => 'products']) }}">{{ $english ? 'Product range' : ($uzbek ? 'Mahsulotlar assortimenti' : 'Ассортимент продукции') }} <span>↗</span></a>
            <div class="footer-copyright">
                {{ $site->text($locale, 'common', 'copyright') }}
            </div>
            <a href="{{ $contactUrl }}">{{ $english ? 'Order products' : ($uzbek ? 'Mahsulotlarga buyurtma berish' : 'Заказать продукцию') }} ↗</a>
        </div>
    </footer>
</body>
</html>
