@extends('layouts.site')

@section('title', $locale === 'en' ? 'Production - Gurlan Global Teks' : ($locale === 'uz' ? 'Ishlab chiqarish - Gurlan Global Teks' : 'Производство - Gurlan Global Teks'))

@section('content')
    @php
        $english = $locale === 'en';
        $uzbek = $locale === 'uz';
        $facilities = $uzbek
            ? [
                ['Yigiruv ishlab chiqarishi', 'Trützschler, Rieter, Zinser va Saurer uskunalarida ip-kalava ishlab chiqariladi.', 'production/production_s1/DSC04440.jpg'],
                ['Trikotaj ishlab chiqarishi', 'Mayer, Orizio, Pilotelli va Vilike uskunalarida trikotaj matolar tayyorlanadi.', 'production/production_s1/DSC04323.jpg'],
                ['Bo‘yash ishlab chiqarishi', 'Matolar Corino, Ferraro va Odesi texnologiyalari yordamida bo‘yaladi.', 'production/production_s1/kras.jpg'],
                ['Tikuv ishlab chiqarishi', 'Juki, Kansai, Jack va Herbert Pavagon uskunalarida tayyor kiyimlar tikiladi.', 'production/production_s1/DSC04173.jpg'],
                ['Trafaretli bosma ishlab chiqarishi', 'Matoga shablon orqali naqshlar tushiriladi, bu jarayonda Fabrobrand uskunalari qo‘llaniladi.', 'production/production_s5/screen-printing-workshop.png'],
            ]
            : ($english
                ? [
                ['Spinning Production', 'Yarn production using equipment from Trützschler, Rieter, Zinser and Saurer.', 'production/production_s1/DSC04440.jpg'],
                ['Knitting Production', 'Knitted fabrics made on equipment by Mayer, Orizio, Pilotelli and Vilike.', 'production/production_s1/DSC04323.jpg'],
                ['Dyeing Production', 'Fabric dyeing using technologies from Corino, Ferraro and Odesi.', 'production/production_s1/kras.jpg'],
                ['Sewing Production', 'Finished garments made on equipment from Juki, Kansai, Jack and Herbert Pavagon.', 'production/production_s1/DSC04173.jpg'],
                ['Screen Printing Production', 'Fabric designs are applied through screen printing using Fabrobrand equipment.', 'production/production_s5/screen-printing-workshop.png'],
                ]
                : [
                ['Прядильное производство', 'Производство пряжи с использованием оборудования Trützschler, Rieter, Zinser и Saurer.', 'production/production_s1/DSC04440.jpg'],
                ['Вязальное производство', 'Производство трикотажных полотен на оборудовании Mayer, Orizio, Pilotelli и Vilike.', 'production/production_s1/DSC04323.jpg'],
                ['Красильное производство', 'Окрашивание тканей с применением технологий Corino, Ferraro и Odesi.', 'production/production_s1/kras.jpg'],
                ['Швейное производство', 'Производство готовых изделий на оборудовании Juki, Kansai, Jack и Herbert Pavagon.', 'production/production_s1/DSC04173.jpg'],
                ['Производство трафаретной печати', 'Трафаретное нанесение рисунков на ткань с использованием оборудования Fabrobrand.', 'production/production_s5/screen-printing-workshop.png'],
                ]);
        $capacities = $uzbek
            ? [
                ['+', '4 000', 'tonna', 'ip-kalava', 'Ishlab chiqariladigan mahsulot turlari'],
                ['', '300', 'tonna gacha', 'trikotaj mato', 'QATTIQ QOTISHMALAR: mashinasozlik, aviatsiya, kemasozlik va boshqa transport sohalari uchun quvurlar, sterjenlar va profillar'],
                ['+', '3 500', 'tonna', 'bo‘yalgan mato', 'YUMSHOQ QOTISHMALAR: qurilish, ko‘priksozlik va transport uchun buyurtmachi chizmalariga muvofiq standart profillar'],
                ['', '9 000 000', 'gacha', 'tayyor kiyim', 'Rossiya Federatsiyasi va xorijdagi buyurtmachilar uchun ishlab chiqariladi'],
            ]
            : ($english
                ? [
                ['+', '4,000', 'tons', 'of yarn', 'Product nomenclature'],
                ['', '300', 'tons Up to', 'of knitted fabrics', 'HARD ALLOYS: pipes, rods and profiles for engineering, aviation, shipbuilding and other transport sectors'],
                ['+', '3,500', 'tons', 'of dyed fabrics', 'SOFT ALLOYS: standard profiles made to customer drawings for construction, bridge engineering and transport'],
                ['', '9,000,000', 'Up to', 'finished garments', 'Manufactured for customers in the Russian Federation and abroad'],
                ]
                : [
                ['+', '4 000', 'тонн', 'пряжи', 'Номенклатура производимой продукции'],
                ['до', '300', 'тонн', 'трикотажных полотен', 'HARD ALLOYS: трубы, прутки, профили для машиностроения, авиации, судостроения и других отраслей транспорта'],
                ['+', '3 500', 'тонн', 'окрашенных тканей', 'SOFT ALLOYS: стандартный профиль по чертежам заказчика для строительства, мостостроения и транспорта'],
                ['до', '9 000 000', '', 'готовых изделий', 'Для заказчиков Российской Федерации и зарубежных стран'],
                ]);
        $workshops = $uzbek
            ? [
                ['Yigiruv ishlab chiqarishi', ['KD va OE usullarida ip-kalava ishlab chiqarish', 'Yetakchi brendlarning zamonaviy uskunalari', 'Barqaror sifat va mahsulotning yuqori mustahkamligi'], 'production/production_s5/DSC04386.jpg'],
                ['Trikotaj ishlab chiqarishi', ['Turli xil trikotaj matolar', 'Mayer, Orizio va Pilotelli texnologiyalari', 'Buyurtmachi talablariga moslashuvchan ishlab chiqarish'], 'production/production_s5/DSC04316.jpg'],
                ['Bo‘yash ishlab chiqarishi', ['Sifat nazorati bilan matolarni bo‘yash', 'Corino, Ferraro va Odesi texnologiyalari', 'Rang mustahkamligi va ekologik jarayonlar'], 'production/production_s5/DSC01066-optimized.jpg'],
                ['Bosma va tikuvchilik ishlab chiqarishi', ['Shablonli bosma va naqsh tushirish', 'To‘liq siklli tayyor kiyim ishlab chiqarish', 'Fabrobrand, Juki, Kansai va Jack uskunalari', 'Yiliga 9 million donagacha kiyim'], 'production/production_s5/DSC04263.jpg'],
                ['Trafaretli bosma ishlab chiqarishi', ['Matoga shablon orqali naqsh tushirish', 'Oval va dumaloq bosma uskunalari', 'Rang va sifat nazorati'], 'production/production_s5/screen-printing-workshop.png'],
                ['Ofis va maʼmuriy bino', ['Korxona boshqaruvi va loyiha bo‘limlari', 'Sifat nazorati va tashqi hamkorlik bilan ishlash', 'Zamonaviy hamda qulay ish muhiti'], 'production/production_s5/office-building.jpg'],
            ]
            : ($english
                ? [
                ['Spinning Production', ['KD and OE yarn production', 'Modern equipment from leading brands', 'Consistent quality and high product strength'], 'production/production_s5/DSC04386.jpg'],
                ['Knitting Production', ['Different types of knitted fabrics', 'Mayer, Orizio and Pilotelli technologies', 'Flexible production to customer requirements'], 'production/production_s5/DSC04316.jpg'],
                ['Dyeing Production', ['Fabric dyeing with quality control', 'Corino, Ferraro and Odesi technologies', 'Color fastness and eco-friendly processes'], 'production/production_s5/DSC01066-optimized.jpg'],
                ['Printing and Garment Manufacturing', ['Screen printing and design application', 'Full-cycle garment production', 'Fabrobrand, Juki, Kansai and Jack equipment', 'Up to 9 million garments a year'], 'production/production_s5/DSC04263.jpg'],
                ['Screen Printing Production', ['Screen-printed designs on fabric', 'Oval and rotary printing equipment', 'Colour and quality control'], 'production/production_s5/screen-printing-workshop.png'],
                ['Office and Administration Building', ['Company management and project departments', 'Quality control and partner relations', 'Modern and comfortable working environment'], 'production/production_s5/office-building.jpg'],
                ]
                : [
                ['Прядильное производство', ['Производство пряжи KD и OE', 'Современное оборудование ведущих брендов', 'Стабильное качество и высокая прочность продукции'], 'production/production_s5/DSC04386.jpg'],
                ['Вязальное производство', ['Производство трикотажных полотен различных типов', 'Технологии Mayer, Orizio, Pilotelli', 'Гибкость под требования заказчика'], 'production/production_s5/DSC04316.jpg'],
                ['Красильное производство', ['Окрашивание тканей с контролем качества', 'Технологии Corino, Ferraro, Odesi', 'Стойкость цвета и экологичные процессы'], 'production/production_s5/DSC01066-optimized.jpg'],
                ['Печать и швейное производство', ['Трафаретная печать и нанесение принтов', 'Производство готовых изделий полного цикла', 'Оборудование Fabrobrand, Juki, Kansai, Jack', 'До 9 млн изделий в год'], 'production/production_s5/DSC04263.jpg'],
                ['Производство трафаретной печати', ['Трафаретное нанесение рисунков на ткань', 'Овальные и ротационные печатные машины', 'Контроль цвета и качества печати'], 'production/production_s5/screen-printing-workshop.png'],
                ['Офис и административный корпус', ['Управление компанией и проектные подразделения', 'Контроль качества и работа с партнёрами', 'Современная и комфортная рабочая среда'], 'production/production_s5/office-building.jpg'],
                ]);
    @endphp

    <section class="page-hero image-hero production-hero">
        <img src="{{ asset('gurlan-assets/production/production_header/DSC04130-optimized.jpg') }}" alt="" fetchpriority="high">
        <div class="page-hero-shade"></div>
        <h1>{{ $english ? 'PRODUCTION' : ($uzbek ? 'ISHLAB CHIQARISH' : 'ПРОИЗВОДСТВО') }}</h1>
    </section>

    <section class="content-section production-complex">
        <div class="section-shell">
            <div class="section-heading">
                <h2>{{ $english ? 'PRODUCTION COMPLEX' : ($uzbek ? 'ISHLAB CHIQARISH MAJMUASI' : 'ПРОИЗВОДСТВЕННЫЙ КОМПЛЕКС') }}</h2>
                <p>{{ $english ? 'Gurlan Global Teks integrates every stage of the textile cycle, from cotton processing to finished garments. Advanced technologies and quality control at each stage ensure stability, efficiency and compliance with international standards.' : ($uzbek ? 'Gurlan Global Teks paxtani qayta ishlashdan tayyor kiyim ishlab chiqarishgacha bo‘lgan tekstil jarayonining barcha bosqichlarini birlashtiradi. Zamonaviy texnologiyalar va har bir bosqichdagi sifat nazorati barqarorlik, samaradorlik hamda xalqaro standartlarga muvofiqlikni ta’minlaydi.' : 'Современная производственная структура Gurlan Global Teks объединяет все этапы текстильного цикла — от переработки хлопка до выпуска готовой продукции. Интеграция процессов, передовые технологии и контроль качества на каждом этапе обеспечивают стабильность, эффективность и соответствие международным стандартам.') }}</p>
                <a class="text-button" href="#workshops">{{ $english ? 'Our products' : ($uzbek ? 'Mahsulotlarimiz' : 'Наша продукция') }} <span>↘</span></a>
            </div>
            <div class="facility-grid">
                @foreach ($facilities as $facility)
                    <article class="facility-card">
                        <img src="{{ asset('gurlan-assets/'.$facility[2]) }}" alt="{{ $facility[0] }}" loading="lazy">
                        <div>
                            <h3>{{ $facility[0] }}</h3>
                            <p>{{ $facility[1] }}</p>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="capacity-feature">
        <div class="capacity-feature-copy">
            <p class="eyebrow">GURLAN GLOBAL TEKS</p>
            <h2>{{ $english ? 'PRODUCTION CAPACITIES OF GURLAN GLOBAL TEKS' : ($uzbek ? 'GURLAN GLOBAL TEKS ISHLAB CHIQARISH QUVVATLARI' : 'ПРОИЗВОДСТВЕННЫЕ МОЩНОСТИ GURLAN GLOBAL TEKS') }}</h2>
            <p>{{ $english ? 'The company’s total production capacity supports a full-cycle textile process, from yarn to finished garments. Each year, the enterprise produces thousands of tons of products that meet international quality standards.' : ($uzbek ? 'Kompaniyaning umumiy quvvati ip-kalavadan tayyor kiyimgacha bo‘lgan to‘liq tekstil ishlab chiqarish siklini ta’minlaydi. Korxonada har yili xalqaro sifat standartlariga javob beradigan minglab tonna mahsulot ishlab chiqariladi.' : 'Суммарные производственные мощности компании обеспечивают полный цикл текстильного производства — от пряжи до готовой продукции. Ежегодно предприятие выпускает тысячи тонн продукции, включая пряжу, ткани и готовые изделия, соответствующие международным стандартам качества.') }}</p>
        </div>
        <img src="{{ asset('gurlan-assets/production/production_s2/DSC04180.jpg') }}" alt="{{ $english ? 'Textile factory' : ($uzbek ? 'Tekstil ishlab chiqarish' : 'Текстильное производство') }}" loading="lazy">
    </section>

    <section class="content-section capacity-section">
        <div class="section-shell">
            <div class="section-heading">
                <h2>{{ $english ? 'ANNUALLY, THE COMPANY PRODUCES' : ($uzbek ? 'KOMPANIYA YILIGA ISHLAB CHIQARADI' : 'ЕЖЕГОДНО КОМПАНИЯ ПРОИЗВОДИТ') }}</h2>
                <p>{{ $english ? 'Modern technology and production scale enable stable supplies to international markets.' : ($uzbek ? 'Zamonaviy texnologiyalar va ishlab chiqarish ko‘lami xalqaro bozorlarga barqaror yetkazib berish imkonini beradi.' : 'Современные технологии и масштаб производства позволяют обеспечивать стабильные поставки на международные рынки.') }}</p>
            </div>
            <div class="capacity-grid">
                @foreach ($capacities as $capacity)
                    <article class="capacity-card">
                        <h3>
                            <span>{{ $capacity[0] }}</span>
                            <span data-count-up>{{ $capacity[1] }}</span>
                            <span>{{ $capacity[2] }}</span>
                        </h3>
                        <strong>{{ $capacity[3] }}</strong>
                        <p>{{ $capacity[4] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="content-section certification-section">
        <div class="section-shell certification-layout">
            <div class="section-heading">
                <p class="eyebrow">{{ $english ? 'OUR STANDARDS' : ($uzbek ? 'BIZNING STANDARTLAR' : 'НАШИ СТАНДАРТЫ') }}</p>
                <h2>{{ $english ? 'CERTIFICATION AND QUALITY' : ($uzbek ? 'SERTIFIKATSIYA VA SIFAT' : 'СЕРТИФИКАЦИЯ И КАЧЕСТВО') }}</h2>
                <p>{{ $english ? 'Modern technologies, quality control at every stage and responsible resource management allow us to offer competitive products for the global market.' : ($uzbek ? 'Zamonaviy texnologiyalar, barcha bosqichlarda sifat nazorati va resurslardan mas’uliyatli foydalanish jahon bozoriga raqobatbardosh mahsulot taklif qilish imkonini beradi.' : 'Современные технологии, контроль качества на всех этапах производства и ответственное отношение к ресурсам позволяют выпускать конкурентоспособную продукцию для глобального рынка.') }}</p>
                <p>{{ $english ? 'Transparency, environmental responsibility and continuous process improvement guide our work with international partners.' : ($uzbek ? 'Xalqaro hamkorlar bilan ishimiz shaffoflik, ekologik mas’uliyat va jarayonlarni uzluksiz takomillashtirish tamoyillariga asoslanadi.' : 'Наша деятельность основана на принципах прозрачности, экологической ответственности и постоянного совершенствования процессов.') }}</p>
            </div>
            <div class="certificate-list">
                <article class="certificate-card">
                    <div><h3>OEKO-TEX®</h3><p>{{ $english ? 'Textile product safety certificate' : ($uzbek ? 'Tekstil mahsulotlari xavfsizligi sertifikati' : 'Сертификат безопасности текстильной продукции') }}</p></div>
                    <a href="{{ asset('gurlan-assets/files/oeko.PDF') }}" target="_blank" rel="noopener noreferrer">{{ $english ? 'Download' : ($uzbek ? 'Yuklab olish' : 'Скачать') }} ↗</a>
                </article>
                <article class="certificate-card">
                    <div><h3>SEDEX</h3><p>{{ $english ? 'Ethical and responsible business standard' : ($uzbek ? 'Axloqiy va mas’uliyatli biznes standarti' : 'Стандарт этичной и ответственной деловой практики') }}</p></div>
                    <a href="{{ asset('gurlan-assets/files/sedex.PDF') }}" target="_blank" rel="noopener noreferrer">{{ $english ? 'Download' : ($uzbek ? 'Yuklab olish' : 'Скачать') }} ↗</a>
                </article>
            </div>
        </div>
    </section>

    <section class="content-section workshops-section" id="workshops">
        <div class="section-shell">
            <div class="section-heading">
                <h2>{{ $english ? 'MODERN FULL-CYCLE TEXTILE PRODUCTION' : ($uzbek ? 'ZAMONAVIY TO‘LIQ SIKLLI TEKSTIL ISHLAB CHIQARISH' : 'СОВРЕМЕННОЕ ТЕКСТИЛЬНОЕ ПРОИЗВОДСТВО ПОЛНОГО ЦИКЛА') }}</h2>
            </div>
            <div class="workshop-grid">
                @foreach ($workshops as $workshop)
                    <article class="workshop-card">
                        <img src="{{ asset('gurlan-assets/'.$workshop[2]) }}" alt="{{ $workshop[0] }}" loading="lazy">
                        <div>
                            <h3>{{ $workshop[0] }}</h3>
                            <ul>
                                @foreach ($workshop[1] as $detail)
                                    <li>{{ $detail }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </article>
                @endforeach
            </div>
            <a class="text-button" href="{{ route('site.page', ['locale' => $locale, 'page' => 'contact']) }}">{{ $english ? 'Contacts' : ($uzbek ? 'Aloqa' : 'Контакты') }} <span>↗</span></a>
        </div>
    </section>
@endsection
