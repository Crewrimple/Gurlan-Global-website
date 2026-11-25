@extends('layouts.site')

@section('title', $locale === 'en' ? 'About Company - Gurlan Global Teks' : ($locale === 'uz' ? 'Kompaniya haqida - Gurlan Global Teks' : 'О компании - Gurlan Global Teks'))

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

    <section class="page-hero image-hero">
        <img src="{{ asset('gurlan-assets/about/header/office-building-source.jpg') }}" alt="" fetchpriority="high">
        <div class="page-hero-shade"></div>
        <h1>{{ $english ? 'ABOUT COMPANY' : ($uzbek ? 'KOMPANIYA HAQIDA' : 'О КОМПАНИИ') }}</h1>
    </section>

    <section class="content-section values-section">
        <div class="section-shell">
            <div class="section-heading centered">
                <h2>{{ $english ? 'STRATEGY AND VALUES' : ($uzbek ? 'STRATEGIYA VA QADRIYATLAR' : 'СТРАТЕГИЯ И ЦЕННОСТИ') }}</h2>
                <p>{{ $english ? 'A systematic approach to development where technology, responsibility and international standards form the foundation of everything we do.' : ($uzbek ? 'Texnologiyalar, mas’uliyat va xalqaro standartlarga asoslangan tizimli rivojlanish yondashuvi kompaniyamiz faoliyatining poydevoridir.' : 'Системный подход к развитию, где технологии, ответственность и международные стандарты формируют основу деятельности компании.') }}</p>
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
                <h2>{{ $english ? 'DEVELOPMENT HISTORY' : ($uzbek ? 'RIVOJLANISH TARIXI' : 'ИСТОРИЯ РАЗВИТИЯ') }}</h2>
                <h3>2020 — {{ $english ? 'present' : ($uzbek ? 'hozirgi kungacha' : 'настоящее время') }}</h3>
                @if ($english)
                    <p>Founded in 2020 in the Khorezm region, Gurlan Global Teks set out to build a modern full-cycle textile ecosystem.</p>
                    <p>By bringing every stage of production together, introducing new technologies and developing exports, the company quickly established a strong market position.</p>
                    <p>Today, Gurlan Global Teks is a rapidly developing industrial cluster focused on quality, innovation and international cooperation.</p>
                @elseif ($uzbek)
                    <p>Gurlan Global Teks 2020-yilda Xorazm viloyatida tashkil etilgan bo‘lib, boshidanoq to‘liq siklli zamonaviy tekstil ekotizimini yaratishni maqsad qilgan.</p>
                    <p>Ishlab chiqarishning barcha bosqichlarini birlashtirish, yangi texnologiyalarni joriy etish va eksportni rivojlantirish kompaniyaning qisqa muddatda bozorda mustahkam o‘rin egallashiga yordam berdi.</p>
                    <p>Bugun Gurlan Global Teks — sifat, innovatsiya va xalqaro hamkorlikka e’tibor qaratayotgan jadal rivojlanayotgan sanoat klasteri.</p>
                @else
                    <p>Основанная в 2020 году в Хорезмской области, Gurlan Global Teks с самого начала ориентировалась на создание современной текстильной экосистемы полного цикла.</p>
                    <p>Объединение всех этапов производства, внедрение технологий и развитие экспортных направлений позволили компании в короткие сроки занять устойчивые позиции на рынке.</p>
                    <p>Сегодня Gurlan Global Teks — динамично развивающийся промышленный кластер с фокусом на качество, инновации и международное сотрудничество.</p>
                @endif
            </div>
            <img class="history-image" src="{{ asset('gurlan-assets/about/about_s3/DSC04379.jpg') }}" alt="{{ $english ? 'Company history' : ($uzbek ? 'Kompaniyaning rivojlanish tarixi' : 'История развития') }}" loading="lazy">
        </div>
    </section>

    <section class="content-section team-section">
        <div class="section-shell">
            <div class="section-heading">
                <h2>{{ $english ? 'THE STRENGTH OF OUR COMPANY' : ($uzbek ? 'KOMPANIYAMIZNING KUCHI' : 'СИЛА КОМПАНИИ') }}</h2>
            </div>
            <div class="team-grid">
                @foreach ($team as $member)
                    <article class="team-card">
                        <img src="{{ asset('gurlan-assets/'.$member[2]) }}" alt="{{ $member[0] }}" loading="lazy">
                        <div><h3>{{ $member[0] }}</h3><p>{{ $member[1] }}</p></div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="content-section activity-section">
        <div class="section-shell">
            <div class="section-heading">
                <h2>{{ $english ? 'BUSINESS AREAS' : ($uzbek ? 'FAOLIYAT YO‘NALISHLARI' : 'НАПРАВЛЕНИЯ ДЕЯТЕЛЬНОСТИ') }}</h2>
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
        <img src="{{ asset('gurlan-assets/about/about_s6/abu.photographer-84-optimized.jpg') }}" alt="" loading="lazy">
        <div class="sustainability-copy">
            <p class="eyebrow">{{ $english ? 'RESPONSIBLE PRODUCTION' : ($uzbek ? 'MAS’ULIYATLI ISHLAB CHIQARISH' : 'ОТВЕТСТВЕННОЕ ПРОИЗВОДСТВО') }}</p>
            <h2>{{ $english ? 'SUSTAINABLE DEVELOPMENT' : ($uzbek ? 'BARQAROR RIVOJLANISH' : 'УСТОЙЧИВОЕ РАЗВИТИЕ') }}</h2>
            <p>{{ $english ? 'Vertical integration protects your business from raw-material shortages and price fluctuations. We guarantee transparent production and consistent quality, supported by OEKO-TEX and SEDEX standards.' : ($uzbek ? 'Vertikal integratsiya biznesingizni xomashyo tanqisligi va narxlar o‘zgarishidan himoya qiladi. OEKO-TEX va SEDEX standartlari bilan tasdiqlangan shaffof ishlab chiqarish va barqaror sifatni kafolatlaymiz.' : 'Вертикальная интеграция Gurlan Global Teks защищает ваш бизнес от дефицита сырья и скачков цен. Мы гарантируем прозрачность производства и стабильное качество, подтверждённое международными сертификатами OEKO-TEX и SEDEX.') }}</p>
            <a href="{{ route('site.page', ['locale' => $locale, 'page' => 'production']) }}">{{ $english ? 'Learn more' : ($uzbek ? 'Batafsil' : 'Подробнее') }} <span>↗</span></a>
        </div>
    </section>

    <section class="content-section exhibition-section">
        <div class="section-shell">
            <div class="section-heading">
                <h2>{{ $english ? 'EXHIBITIONS' : ($uzbek ? 'KO‘RGAZMALAR' : 'ВЫСТАВКИ') }}</h2>
            </div>
            <div class="exhibition-tabs" role="group" aria-label="{{ $english ? 'Exhibition categories' : ($uzbek ? 'Ko‘rgazma toifalari' : 'Категории выставок') }}">
                <button type="button" class="is-active" aria-pressed="true">{{ $english ? 'International exhibitions' : ($uzbek ? 'Xalqaro ko‘rgazmalar' : 'Международные выставки') }}</button>
                <button type="button" disabled>{{ $english ? 'Industry events' : ($uzbek ? 'Soha tadbirlari' : 'Отраслевые мероприятия') }}</button>
                <button type="button" disabled>{{ $english ? 'Forums and business meetings' : ($uzbek ? 'Forumlar va biznes uchrashuvlari' : 'Форумы и бизнес-встречи') }}</button>
            </div>
            <div class="exhibition-grid">
                @foreach (['vistvka_0_0.jpg', 'vistvka_0_1.jpg', 'vistvka_0_2.jpg'] as $image)
                    <div class="exhibition-photo">
                        <img src="{{ asset('gurlan-assets/about/about_s7/'.$image) }}" alt="{{ $english ? 'International exhibition' : ($uzbek ? 'Xalqaro ko‘rgazma' : 'Международная выставка') }}" loading="lazy">
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
