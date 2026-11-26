@extends('layouts.site')

@section('title', $site->text($locale, 'common', 'home_title'))

@section('content')
    @php
        $english = $locale === 'en';
        $uzbek = $locale === 'uz';
        $products = $uzbek
            ? [
                ['Paxta', 'Zamonaviy agrotexnologiyalar va barqaror ishlab chiqarish standartlari asosida yetishtirilgan yuqori sifatli tabiiy xomashyo.', 'home/home_s3/716da3ecb5500d70b1b469f8dd6fb673.jpg'],
                ['Ip-kalava', 'Trützschler, Rieter, Zinser va Saurer uskunalarida yiliga 4 000 tonna ip-kalava ishlab chiqaramiz.', 'home/home_s3/DSC04412.jpg'],
                ['Bo‘yash va pardozlash', 'Bo‘yash quvvati yiliga 3 500 tonna. Zamonaviy texnologiyalar rang mustahkamligi, yumshoqlik va chidamlilikni ta’minlaydi.', 'home/home_s3/DSC01061.jpg'],
                ['Trikotaj mato', 'Mayer, Orizio, Pilotelli va Vilike uskunalarida yuqori sifatli trikotaj matolar ishlab chiqariladi.', 'home/home_s3/image_2026-04-18_12-51-17.jpg'],
                ['Tayyor kiyimlar', 'Yiliga 6 000 000 tagacha tayyor kiyim ishlab chiqarib, yirik chakana savdo tarmoqlariga barqaror yetkazib beramiz.', 'home/home_s3/kkkkkk3.jpg'],
            ]
            : ($english
                ? [
                ['Cotton', 'High-quality natural raw material, grown using modern agricultural technologies and sustainable production standards.', 'home/home_s3/716da3ecb5500d70b1b469f8dd6fb673.jpg'],
                ['Yarn', 'We produce 4,000 tons of yarn annually using leading equipment from Trützschler, Rieter, Zinser and Saurer.', 'home/home_s3/DSC04412.jpg'],
                ['Dyeing and finishing', 'Annual dyeing capacity of 3,500 tons. Advanced technology ensures color fastness, softness and durability.', 'home/home_s3/DSC01061.jpg'],
                ['Knitted fabrics', 'High-quality knitted fabrics made on equipment by Mayer, Orizio, Pilotelli and Vilike.', 'home/home_s3/image_2026-04-18_12-51-17.jpg'],
                ['Finished garments', 'Up to 6,000,000 finished garments per year, with reliable supply for major retailers.', 'home/home_s3/kkkkkk3.jpg'],
                ]
                : [
                ['Хлопок', 'Натуральное сырьё высокого качества, выращенное с соблюдением современных агротехнологий и стандартов устойчивого производства.', 'home/home_s3/716da3ecb5500d70b1b469f8dd6fb673.jpg'],
                ['Пряжа', 'Производственная мощность составляет 4000 тонн пряжи в год. Мы используем оборудование Trützschler, Rieter, Zinser и Saurer.', 'home/home_s3/DSC04412.jpg'],
                ['Крашение и отделка', 'Мощность цеха крашения — 3,5 тысячи тонн полотна в год. Современные технологии обеспечивают стойкость цвета и долговечность трикотажа.', 'home/home_s3/DSC01061.jpg'],
                ['Ткани', 'Трикотажное полотно высокого качества на оборудовании Mayer, Orizio, Pilotelli и Vilike.', 'home/home_s3/image_2026-04-18_12-51-17.jpg'],
                ['Готовая продукция', 'Фабрика выпускает до 6 000 000 изделий в год, обеспечивая стабильные поставки для крупного ритейла.', 'home/home_s3/kkkkkk3.jpg'],
                ]);
        $stats = $uzbek
            ? [
                ['№1', 'Paxta tolasidan tayyor kiyimgacha to‘liq integratsiyalashgan tekstil ishlab chiqarish'],
                ['Sertifikatlar', 'OEKO-TEX, SEDEX, ISO. BCI va Better Cotton jarayonda'],
                ['Eksport', 'Xalqaro bozorlarga mahsulot yetkazib berish tajribasi'],
                ['6 000 000', 'Yiliga ishlab chiqariladigan tayyor kiyimlar'],
                ['2020-yildan beri', 'Jadal rivojlanish va xalqaro bozorlarga chiqish'],
                ['1 000+ xodim', 'Malakali va tajribali jamoa'],
            ]
            : ($english
                ? [
                ['No. 1', 'Vertically integrated full-cycle textile production'],
                ['Certifications', 'OEKO-TEX, SEDEX, ISO. BCI and Better Cotton in progress'],
                ['Exports', 'Extensive experience supplying international markets'],
                ['6,000,000', 'Finished garments produced annually'],
                ['Since 2020', 'Rapid development and growth in international markets'],
                ['1,000+ employees', 'A professional and experienced team'],
                ]
                : [
                ['№1', 'Вертикально интегрированное текстильное производство полного цикла'],
                ['Наши сертификаты', 'OEKO-TEX, SEDEX, ISO. BCI и Better Cotton в процессе'],
                ['Экспорт', 'Опыт работы и поставок в зарубежные страны'],
                ['6 000 000', 'Готовых изделий производим ежегодно'],
                ['С 2020 года', 'Динамичное развитие и выход на международный рынок'],
                ['1000+ сотрудников', 'Профессиональная команда предприятия'],
                ]);
        $advantages = $uzbek
            ? [
                ['To‘liq ishlab chiqarish sikli', 'Paxtadan tayyor kiyimgacha — har bir bosqichda sifat nazorati.'],
                ['Yuqori sifat', 'Zamonaviy uskunalar va standartlar barqaror sifat hamda xalqaro talablarga muvofiqlikni ta’minlaydi.'],
                ['Eksportga yo‘naltirilganlik', 'Xalqaro hamkorlik va global bozorlarda ishlash tajribasi.'],
                ['Ishonchli hamkorlik', 'Ishonch va majburiyatlarni bajarishga asoslangan uzoq muddatli munosabatlar.'],
                ['Innovatsiya va rivojlanish', 'Zamonaviy texnologiyalarni joriy etish va ishlab chiqarish jarayonlarini uzluksiz takomillashtirish.'],
                ['Barqaror ishlab chiqarish', 'Atrof-muhitga mas’uliyatli munosabat va resurslardan oqilona foydalanish.'],
            ]
            : ($english
                ? [
                ['Full-cycle production', 'Vertical integration — from cotton to finished garments with quality control at every stage.'],
                ['High quality', 'Modern equipment and standards ensure consistent quality and international compliance.'],
                ['Export-oriented', 'International partnerships and proven experience across global markets.'],
                ['Reliable partnership', 'Long-term relationships built on trust and dependable delivery.'],
                ['Innovation and growth', 'Modern technologies and continuous improvement of production processes.'],
                ['Sustainable production', 'Environmental responsibility and efficient use of resources.'],
                ]
                : [
                ['Полный цикл производства', 'Вертикальная интеграция — от хлопка до готовой одежды с контролем качества на каждом этапе.'],
                ['Высокое качество', 'Современное оборудование и стандарты обеспечивают стабильность и соответствие международным требованиям.'],
                ['Экспортная ориентация', 'Развитое международное сотрудничество и опыт работы с глобальными рынками.'],
                ['Надёжное партнёрство', 'Долгосрочные отношения, основанные на доверии и выполнении обязательств.'],
                ['Инновации и развитие', 'Внедрение современных технологий и постоянная оптимизация производства.'],
                ['Устойчивое производство', 'Экологическая ответственность и эффективное использование ресурсов.'],
                ]);
        $whyUs = $english
            ? 'We provide complete quality control at every stage, from growing cotton to sewing finished garments. Our annual capacity is 6,000,000 products, with ISO, OEKO-TEX and SEDEX standards, in-house spinning and dyeing, and delivery schedules from 7 to 35 working days. We offer transparent, dependable partnerships and private-label production tailored to your business.'
            : ($uzbek
                ? 'Biz paxta yetishtirishdan tayyor kiyim tikishgacha bo‘lgan barcha bosqichlarda sifatni to‘liq nazorat qilamiz. Fabrika yiliga 6 000 000 dona mahsulot ishlab chiqaradi. Ishlab chiqarish ISO, OEKO-TEX va SEDEX xalqaro standartlari bo‘yicha sertifikatlangan. O‘zimizning yigiruv va bo‘yash sexlarimiz mato sifatining barqarorligini ta’minlaydi, ishlab chiqarish muddati esa 7–35 ish kunini tashkil etadi. Biz shaffof hamkorlikni va biznesingiz talablariga mos xususiy brend ostida ishlab chiqarishni taklif qilamiz.'
                : 'Мы обеспечиваем полный контроль качества на всех этапах: от выращивания хлопка до пошива готовой одежды. Производственная мощность фабрики — 6 000 000 изделий в год. Производство сертифицировано по международным стандартам ISO, OEKO-TEX и SEDEX. Собственные цеха прядения и крашения гарантируют стабильность полотна, а сроки производства составляют от 7 до 35 рабочих дней. Предлагаем прозрачное партнёрство и работу по системе СТМ под задачи вашего бизнеса.');
    @endphp

    <section class="home-hero" data-hero-slider>
        <div class="hero-slides">
            <img class="hero-slide is-active" src="{{ $site->media('home_hero_1') }}" alt="" fetchpriority="high" data-hero-slide>
            <img class="hero-slide" src="{{ $site->media('home_hero_2') }}" alt="" fetchpriority="low" data-hero-slide>
        </div>
        <div class="hero-shade"></div>
        <div class="home-hero-copy">
            <h1>{{ $site->text($locale, 'home', 'hero_title') }}</h1>
            <button class="hero-video-button" type="button" data-video-open data-video-src="{{ $site->media('home_video') }}" aria-haspopup="dialog" aria-controls="home-video-dialog">
                <span class="play-icon" aria-hidden="true">▶</span>
                <span>{{ $english ? 'Watch video' : ($uzbek ? 'Videoni ko‘rish' : 'Посмотреть видео') }}</span>
            </button>
        </div>
        <div class="hero-dots" aria-label="{{ $english ? 'Choose slide' : ($uzbek ? 'Slaydni tanlang' : 'Выбрать слайд') }}">
            <button type="button" class="is-active" data-hero-dot="0" aria-label="1"></button>
            <button type="button" data-hero-dot="1" aria-label="2"></button>
        </div>
    </section>

    <dialog class="video-dialog" id="home-video-dialog" data-video-dialog aria-labelledby="home-video-title">
        <div class="video-dialog-panel">
            <div class="video-dialog-header">
                <div>
                    <p class="video-dialog-eyebrow">GURLAN GLOBAL TEKS</p>
                    <h2 id="home-video-title">{{ $english ? 'Our production' : ($uzbek ? 'Ishlab chiqarishimiz' : 'Наше производство') }}</h2>
                </div>
                <button class="video-dialog-close" type="button" data-video-close aria-label="{{ $english ? 'Close video' : ($uzbek ? 'Videoni yopish' : 'Закрыть видео') }}">×</button>
            </div>
            <div class="video-dialog-player">
                <iframe
                    data-video-frame
                    src="about:blank"
                    title="{{ $english ? 'Gurlan Global Teks video player' : ($uzbek ? 'Gurlan Global Teks video pleyeri' : 'Видеоплеер Gurlan Global Teks') }}"
                    allow="autoplay; encrypted-media; picture-in-picture; web-share"
                    referrerpolicy="strict-origin-when-cross-origin"
                    allowfullscreen
                ></iframe>
            </div>
        </div>
    </dialog>

    <section class="content-section indicators-section">
        <div class="section-shell">
            <div class="section-heading centered">
                <h2>{{ $site->text($locale, 'home', 'indicators_heading') }}</h2>
            </div>
            <div class="indicator-intro">
                <p>{{ $site->text($locale, 'home', 'indicators_intro_1') }}</p>
                <p>{{ $site->text($locale, 'home', 'indicators_intro_2') }}</p>
            </div>
            <div class="indicator-grid">
                @foreach ($stats as $index => $stat)
                    <article class="indicator-card">
                        <strong @if (in_array($index, [3, 5], true)) data-count-up @endif>{{ $stat[0] }}</strong>
                        <span>{{ $stat[1] }}</span>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="content-section products-section" id="catalog">
        <div class="section-shell">
            <div class="section-heading">
                <h2>{{ $site->text($locale, 'home', 'products_heading') }}</h2>
                <p>{{ $site->text($locale, 'home', 'products_intro') }}</p>
            </div>
            <div class="product-showcase">
                @foreach ($products as $index => $product)
                    <article class="product-tile product-tile-{{ $index + 1 }}">
                        <img src="{{ asset('gurlan-assets/'.$product[2]) }}" alt="{{ $product[0] }}" loading="lazy">
                        <span class="product-tile-shade"></span>
                        <div class="product-tile-copy">
                            <strong>{{ $product[0] }}</strong>
                            <small>{{ $product[1] }}</small>
                        </div>
                    </article>
                @endforeach
            </div>
            <a class="text-button" href="{{ route('site.page', ['locale' => $locale, 'page' => 'products']) }}">{{ $english ? 'View product range' : ($uzbek ? 'Assortimentni ko‘rish' : 'Смотреть ассортимент') }} <span>↗</span></a>
        </div>
    </section>

    <section class="content-section advantage-section">
        <div class="section-shell">
            <div class="section-heading">
                <h2>{{ $site->text($locale, 'home', 'advantages_heading') }}</h2>
                <p>{{ $english ? 'Technology, experience and a strategic approach create a sustainable competitive advantage in the international market.' : ($uzbek ? 'Texnologiyalar, tajriba va strategik yondashuv xalqaro bozorda barqaror raqobat ustunligini yaratadi.' : 'Технологии, опыт и стратегический подход формируют устойчивое конкурентное преимущество на международном рынке.') }}</p>
            </div>
            <div class="advantage-list">
                @foreach ($advantages as $advantage)
                    <article class="advantage-item">
                        <h3>{{ $advantage[0] }}</h3>
                        <p>{{ $advantage[1] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="why-section">
        <div class="why-copy">
            <p class="eyebrow">{{ $english ? 'WHY CHOOSE US' : ($uzbek ? 'NEGA BIZNI TANLASHADI' : 'ПОЧЕМУ ВЫБИРАЮТ НАС') }}</p>
            <h2>{{ $site->text($locale, 'home', 'why_heading') }}</h2>
            <p>{{ $site->text($locale, 'home', 'why_text') }}</p>
            <a class="solid-button" href="{{ route('site.page', ['locale' => $locale, 'page' => 'contact']) }}">{{ $english ? 'Contact us' : ($uzbek ? 'Biz bilan bog‘laning' : 'Связаться с нами') }} <span>↗</span></a>
        </div>
        <div class="why-image">
            <img src="{{ $site->media('home_why') }}" alt="" loading="lazy">
        </div>
    </section>
@endsection
