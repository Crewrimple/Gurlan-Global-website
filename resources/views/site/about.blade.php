@extends('layouts.site')

@section('title', $site->text($locale, 'common', 'about_title'))

@section('content')
    @php
        $english = $locale === 'en';
        $uzbek = $locale === 'uz';
        $values = [
            [
                $english ? 'Mission' : ($uzbek ? 'Missiya' : 'Миссия'),
                $english ? 'Supply the global market with quality knitwear through full vertical integration — from cotton seed to the final stitch.' : ($uzbek ? 'Paxta urug‘idan tayyor mahsulotgacha bo‘lgan to‘liq vertikal integratsiya orqali jahon bozorini sifatli trikotaj bilan ta’minlash.' : 'Обеспечивать глобальный рынок качественным трикотажем через полную вертикальную интеграцию — от семени хлопка до финальной строчки.'),
            ],
            [
                $english ? 'Goal' : ($uzbek ? 'Maqsad' : 'Цель'),
                $english ? 'Strengthen our position as a leader in Uzbekistan’s textile industry and grow export potential every year.' : ($uzbek ? 'O‘zbekiston tekstil sanoatidagi yetakchi o‘rnimizni mustahkamlash va eksport salohiyatini har yili oshirish.' : 'Укреплять позиции лидера текстильной отрасли Узбекистана, ежегодно наращивая экспортный потенциал.'),
            ],
            [
                $english ? 'Vision' : ($uzbek ? 'Kelajakdagi maqsadimiz' : 'Видение'),
                $english ? 'Build a sustainable textile ecosystem that meets the most demanding global requirements.' : ($uzbek ? 'Eng yuqori xalqaro talablarga javob beradigan barqaror tekstil ekotizimini yaratish.' : 'Создание устойчивой текстильной экосистемы, соответствующей самым жёстким мировым требованиям.'),
            ],
        ];
        $activities = $uzbek
            ? [
                ['Paxta yetishtirish', 'O‘z dalalarimiz xomashyo ustidan to‘liq nazorat va barqaror tannarxni ta’minlab, biznesingizni bozordagi narx o‘zgarishlaridan himoya qiladi.'],
                ['Ip-kalava ishlab chiqarish', 'Rieter va Saurer uskunalarida yuqori mustahkamlik va barqaror sifatga ega yiliga 4 000 tonna ip-kalava ishlab chiqaramiz.'],
                ['Bo‘yash va pardozlash', 'Yiliga 3 500 tonna ishlab chiqarish quvvati va OEKO-TEX talablariga mos bo‘yoqlar rang mustahkamligi, mato yumshoqligi va ekologik xavfsizlikni ta’minlaydi.'],
                ['Mato ishlab chiqarish', 'Buyurtmachi talablariga mos ravishda kulirkadan futergacha bo‘lgan keng turdagi trikotaj matolarni ishlab chiqaramiz.'],
                ['Tikuvchilik', 'Ikkita zamonaviy majmua yiliga 6 million dona kiyim ishlab chiqaradi va yirik hajmda xususiy brend ostida buyurtmalarni bajaradi.'],
                ['Tayyor mahsulotlar', 'Paxta dalasidan tikuvgacha bo‘lgan to‘liq sikl raqobatbardosh narxlar, shaffof sifat va ishonchli yetkazib berish muddatlarini ta’minlaydi.'],
            ]
            : ($english
                ? [
                ['Cotton growing', 'Our own fields provide complete raw-material control and stable cost, protecting your business from market price fluctuations.'],
                ['Yarn production', 'Rieter and Saurer equipment produces 4,000 tons of yarn with high strength and consistent quality.'],
                ['Dyeing and finishing', 'Annual capacity of 3,500 tons and OEKO-TEX dyes deliver color fastness, a soft finish and environmental safety.'],
                ['Fabric production', 'A wide range of knitwear, from single jersey to fleece, produced to meet customer requirements.'],
                ['Garment manufacturing', 'Two modern complexes produce 6 million garments annually, with private-label manufacturing at scale.'],
                ['Finished products', 'A complete cycle from cotton field to sewing delivers competitive pricing, transparent quality and reliable lead times.'],
                ]
                : [
                ['Выращивание хлопка', 'Собственные поля обеспечивают полный контроль сырья и стабильную себестоимость, защищая бизнес от колебаний цен на хлопок.'],
                ['Производство пряжи', 'Оборудование Rieter и Saurer обеспечивает выпуск 4000 тонн прочной пряжи стабильного качества.'],
                ['Крашение и отделка', 'Мощность 3500 тонн в год и красители OEKO-TEX гарантируют стойкость цвета, мягкость полотна и экологическую безопасность.'],
                ['Производство тканей', 'Широкий ассортимент трикотажа — от кулирки до футера. Собственное производство позволяет создавать полотно под требования заказчика.'],
                ['Швейное производство', 'Два современных комплекса мощностью 6 млн изделий в год работают по системе СТМ и обеспечивают промышленный масштаб выпуска.'],
                ['Готовая продукция', 'Вертикальный цикл от поля до пошива обеспечивает конкурентную цену, прозрачное качество и стабильные сроки поставок.'],
                ]);
        $team = $uzbek
            ? [
                ['Temur Ismoilov', 'Bosh direktor', 'about/about_s4/Ismailov_Temur.jpg'],
                ['Sherzod Qurbonov', 'Bosh direktor o‘rinbosari', 'about/about_s4/Sherzod_Kurbanov.jpg'],
                ['Ismoil Ismoilov', 'Direktor o‘rinbosari', 'about/about_s4/Ismailov_Ismail.jpg'],
                ['Temur Samandarov', 'Paxtani qayta ishlash bo‘yicha direktor', 'about/about_s4/Samandarov_Temur.jpg'],
            ]
            : ($english
                ? [
                    ['Temur Ismoilov', 'General Director', 'about/about_s4/Ismailov_Temur.jpg'],
                    ['Sherzod Kurbonov', 'Deputy General Director', 'about/about_s4/Sherzod_Kurbanov.jpg'],
                    ['Ismoil Ismoilov', 'Deputy Director', 'about/about_s4/Ismailov_Ismail.jpg'],
                    ['Temur Samandarov', 'Director of Cotton Processing', 'about/about_s4/Samandarov_Temur.jpg'],
                ]
                : [
                ['Исмаилов Темур', 'Генеральный директор', 'about/about_s4/Ismailov_Temur.jpg'],
                ['Курбонов Шерзод', 'Заместитель генерального директора', 'about/about_s4/Sherzod_Kurbanov.jpg'],
                ['Исмаилов Исмаил', 'Заместитель директора', 'about/about_s4/Ismailov_Ismail.jpg'],
                ['Самандаров Темур', 'Директор по переработке хлопка', 'about/about_s4/Samandarov_Temur.jpg'],
                ]);
    @endphp

    <section class="page-hero image-hero about-hero">
        <img src="{{ $site->media('about_hero') }}" alt="" fetchpriority="high">
        <div class="page-hero-shade"></div>
        <h1>{{ $site->text($locale, 'about', 'page_heading') }}</h1>
    </section>

    <section class="content-section values-section">
        <div class="section-shell">
            <div class="section-heading centered">
                <h2>{{ $site->text($locale, 'about', 'values_heading') }}</h2>
                <p>{{ $site->text($locale, 'about', 'values_intro') }}</p>
            </div>
            <div class="values-list">
                @foreach ($values as $value)
                    <article class="value-item">
                        <div>
                            <h3>{{ $value[0] }}</h3>
                            <p>{{ $value[1] }}</p>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="content-section history-section">
        <div class="section-shell history-layout">
            <div class="history-copy">
                <p class="eyebrow">{{ $english ? 'OUR JOURNEY' : ($uzbek ? 'BIZNING YO‘LIMIZ' : 'НАШ ПУТЬ') }}</p>
                <h2>{{ $site->text($locale, 'about', 'history_heading') }}</h2>
                <h3>2020 — {{ $english ? 'present' : ($uzbek ? 'hozirgi kungacha' : 'настоящее время') }}</h3>
                <p>{{ $site->text($locale, 'about', 'history_1') }}</p>
                <p>{{ $site->text($locale, 'about', 'history_2') }}</p>
                <p>{{ $site->text($locale, 'about', 'history_3') }}</p>
            </div>
            <img class="history-image" src="{{ $site->media('about_history') }}" alt="{{ $english ? 'Company history' : ($uzbek ? 'Kompaniyaning rivojlanish tarixi' : 'История развития') }}" loading="lazy">
        </div>
    </section>

    <section class="content-section team-section">
        <div class="section-shell">
            <div class="section-heading">
                <h2>{{ $site->text($locale, 'about', 'team_heading') }}</h2>
            </div>
            <div class="team-grid">
                @foreach ($cmsTeam as $member)
                    <article class="team-card">
                        <img src="{{ str_starts_with($member->image_path, 'gurlan-assets/') ? asset($member->image_path) : asset('storage/'.$member->image_path) }}" alt="{{ $member->localized($locale, 'name') }}" loading="lazy">
                        <div><h3>{{ $member->localized($locale, 'name') }}</h3><p>{{ $member->localized($locale, 'position') }}</p></div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="content-section activity-section">
        <div class="section-shell">
            <div class="section-heading">
                <h2>{{ $site->text($locale, 'about', 'activities_heading') }}</h2>
                <p>{{ $english ? 'Gurlan Global Teks is an integrated textile company bringing every key production stage together — from raw materials to finished products.' : ($uzbek ? 'Gurlan Global Teks — xomashyodan tayyor mahsulotgacha bo‘lgan asosiy ishlab chiqarish bosqichlarini birlashtirgan integratsiyalashgan tekstil kompaniyasi.' : 'Gurlan Global Teks — интегрированная текстильная компания, объединяющая ключевые этапы производства в единую систему — от сырья до готовой продукции.') }}</p>
            </div>
            <div class="activity-grid">
                @foreach ($activities as $activity)
                    <article class="activity-card">
                        <h3>{{ $activity[0] }}</h3>
                        <p>{{ $activity[1] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="sustainability-section">
        <img src="{{ $site->media('about_sustainability') }}" alt="" loading="lazy">
        <div class="sustainability-copy">
            <p class="eyebrow">{{ $english ? 'RESPONSIBLE PRODUCTION' : ($uzbek ? 'MAS’ULIYATLI ISHLAB CHIQARISH' : 'ОТВЕТСТВЕННОЕ ПРОИЗВОДСТВО') }}</p>
            <h2>{{ $site->text($locale, 'about', 'sustainability_heading') }}</h2>
            <p>{{ $english ? 'Vertical integration protects your business from raw-material shortages and price fluctuations. We guarantee transparent production and consistent quality, supported by OEKO-TEX and SEDEX standards.' : ($uzbek ? 'Vertikal integratsiya biznesingizni xomashyo tanqisligi va narxlar o‘zgarishidan himoya qiladi. OEKO-TEX va SEDEX standartlari bilan tasdiqlangan shaffof ishlab chiqarish va barqaror sifatni kafolatlaymiz.' : 'Вертикальная интеграция Gurlan Global Teks защищает ваш бизнес от дефицита сырья и скачков цен. Мы гарантируем прозрачность производства и стабильное качество, подтверждённое международными сертификатами OEKO-TEX и SEDEX.') }}</p>
            <a href="{{ route('site.page', ['locale' => $locale, 'page' => 'production']) }}">{{ $english ? 'Learn more' : ($uzbek ? 'Batafsil' : 'Подробнее') }} <span>↗</span></a>
        </div>
    </section>

    <section class="content-section exhibition-section">
        <div class="section-shell">
            <div class="section-heading">
                <h2>{{ $site->text($locale, 'about', 'exhibitions_heading') }}</h2>
            </div>
            <div class="exhibition-tabs" role="group" aria-label="{{ $english ? 'Exhibition categories' : ($uzbek ? 'Ko‘rgazma toifalari' : 'Категории выставок') }}">
                <button type="button" class="is-active" aria-pressed="true">{{ $site->text($locale, 'about', 'exhibitions_tab_international') }}</button>
                <button type="button" disabled>{{ $site->text($locale, 'about', 'exhibitions_tab_industry') }}</button>
                <button type="button" disabled>{{ $site->text($locale, 'about', 'exhibitions_tab_forums') }}</button>
            </div>
            <div class="exhibition-grid">
                @foreach (['about_exhibition_1', 'about_exhibition_2', 'about_exhibition_3'] as $mediaKey)
                    <div class="exhibition-photo">
                        <img src="{{ $site->media($mediaKey) }}" alt="{{ $site->text($locale, 'about', 'exhibitions_tab_international') }}" loading="lazy">
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
