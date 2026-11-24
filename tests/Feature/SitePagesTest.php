<?php

it('redirects the root URL to the default language', function () {
    $response = $this->get('/');

    $response->assertRedirect('/ru');
});

it('renders each page in all supported languages', function (string $locale, ?string $page, string $view, string $content) {
    $parameters = ['locale' => $locale];

    if ($page !== null) {
        $parameters['page'] = $page;
    }

    $response = $this->get(route('site.page', $parameters));

    $response->assertOk()
        ->assertViewIs($view)
        ->assertSee($content);
})->with([
    'English home' => ['en', null, 'welcome', 'Key Indicators'],
    'Uzbek home' => ['uz', null, 'welcome', 'Asosiy ko‘rsatkichlar'],
    'Russian about' => ['ru', 'about', 'site.about', 'ИСТОРИЯ РАЗВИТИЯ'],
    'English about' => ['en', 'about', 'site.about', 'DEVELOPMENT HISTORY'],
    'Uzbek about' => ['uz', 'about', 'site.about', 'RIVOJLANISH TARIXI'],
    'Russian production' => ['ru', 'production', 'site.production', 'ПРОИЗВОДСТВЕННЫЙ КОМПЛЕКС'],
    'English production' => ['en', 'production', 'site.production', 'PRODUCTION COMPLEX'],
    'Uzbek production' => ['uz', 'production', 'site.production', 'ISHLAB CHIQARISH MAJMUASI'],
    'Russian products' => ['ru', 'products', 'site.products', 'АССОРТИМЕНТ ПРОДУКЦИИ'],
    'English products' => ['en', 'products', 'site.products', 'PRODUCT RANGE'],
    'Uzbek products' => ['uz', 'products', 'site.products', 'MAHSULOTLAR ASSORTIMENTI'],
    'Russian contact' => ['ru', 'contact', 'site.contact', 'МЫ ЗДЕСЬ, ЧТОБЫ ПОМОЧЬ'],
    'English contact' => ['en', 'contact', 'site.contact', "WE'RE HERE TO HELP"],
    'Uzbek contact' => ['uz', 'contact', 'site.contact', 'SIZGA YORDAM BERISHGA TAYYORMIZ'],
    'Russian news' => ['ru', 'news', 'site.news', 'Новостей пока нет.'],
    'English news' => ['en', 'news', 'site.news', 'No news yet.'],
    'Uzbek news' => ['uz', 'news', 'site.news', 'Hozircha yangiliklar yo‘q.'],
]);

it('omits Javlon Ismoilov from the company team in every language', function (string $locale) {
    $response = $this->get(route('site.page', ['locale' => $locale, 'page' => 'about']));

    $response->assertOk()
        ->assertDontSee('Javlon Ismoilov')
        ->assertDontSee('Исмаилов Жавлон')
        ->assertDontSee('Ismailov_Javlon.jpg');
})->with([
    'Russian company page' => ['ru'],
    'English company page' => ['en'],
    'Uzbek company page' => ['uz'],
]);

it('shows Temur Ismoilov as the general director in every language', function (string $locale, string $name, string $title) {
    $this->get(route('site.page', ['locale' => $locale, 'page' => 'about']))
        ->assertOk()
        ->assertSee($name)
        ->assertSee($title)
        ->assertDontSee('Учредитель')
        ->assertDontSee('Ta’sischi');
})->with([
    'Russian company page' => ['ru', 'Исмаилов Темур', 'Генеральный директор'],
    'English company page' => ['en', 'Temur Ismoilov', 'General Director'],
    'Uzbek company page' => ['uz', 'Temur Ismoilov', 'Bosh direktor'],
]);

it('shows Sherzod Kurbonov as deputy general director in every language', function (string $locale, string $name, string $title) {
    $this->get(route('site.page', ['locale' => $locale, 'page' => 'about']))
        ->assertOk()
        ->assertSee($name)
        ->assertSee($title)
        ->assertDontSee('Начальник отдела по маркетингу и IT')
        ->assertDontSee('Head of Marketing and IT')
        ->assertDontSee('Marketing va IT bo‘limi boshlig‘i');
})->with([
    'Russian company page' => ['ru', 'Курбонов Шерзод', 'Заместитель генерального директора'],
    'English company page' => ['en', 'Sherzod Kurbonov', 'Deputy General Director'],
    'Uzbek company page' => ['uz', 'Sherzod Qurbonov', 'Bosh direktor o‘rinbosari'],
]);

it('shows Ismail Ismoilov as deputy director in every language', function (string $locale, string $name, string $title) {
    $this->get(route('site.page', ['locale' => $locale, 'page' => 'about']))
        ->assertOk()
        ->assertSee($name)
        ->assertSee($title)
        ->assertDontSee('Начальник отдела по производству')
        ->assertDontSee('Head of Production')
        ->assertDontSee('Ishlab chiqarish bo‘limi boshlig‘i');
})->with([
    'Russian company page' => ['ru', 'Исмаилов Исмаил', 'Заместитель директора'],
    'English company page' => ['en', 'Ismoil Ismoilov', 'Deputy Director'],
    'Uzbek company page' => ['uz', 'Ismoil Ismoilov', 'Direktor o‘rinbosari'],
]);

it('orders the company team as requested in every language', function (string $locale, array $names) {
    $response = $this->get(route('site.page', ['locale' => $locale, 'page' => 'about']));

    $response->assertOk();
    $previousPosition = -1;
    $content = $response->getContent();

    foreach ($names as $name) {
        $position = strpos($content, $name);

        expect($position)->toBeInt()->toBeGreaterThan($previousPosition);

        $previousPosition = $position;
    }
})->with([
    'Russian company page' => ['ru', ['Исмаилов Темур', 'Курбонов Шерзод', 'Исмаилов Исмаил', 'Самандаров Темур']],
    'English company page' => ['en', ['Temur Ismoilov', 'Sherzod Kurbonov', 'Ismoil Ismoilov', 'Temur Samandarov']],
    'Uzbek company page' => ['uz', ['Temur Ismoilov', 'Sherzod Qurbonov', 'Ismoil Ismoilov', 'Temur Samandarov']],
]);

it('omits sequence numbers from the values, activity and advantage cards', function () {
    $about = $this->get('/ru/about');

    $about->assertOk()
        ->assertSee('class="values-list"', false)
        ->assertSee('class="activity-grid"', false)
        ->assertDontSee('value-index', false);

    foreach (range(1, 6) as $number) {
        $about->assertDontSee('<span>'.str_pad((string) $number, 2, '0', STR_PAD_LEFT).'</span>', false);
    }

    $this->get('/ru')
        ->assertOk()
        ->assertSee('class="advantage-list"', false)
        ->assertDontSee('advantage-number', false);
});

it('renders the localized video player on the homepage', function (string $locale, string $buttonLabel, string $videoTitle) {
    $response = $this->get(route('site.page', ['locale' => $locale]));

    $response->assertOk()
        ->assertSee($buttonLabel)
        ->assertSee($videoTitle)
        ->assertSee('data-video-open', false)
        ->assertSee('id="home-video-dialog"', false)
        ->assertSee('data-video-frame', false);
})->with([
    'Russian homepage video' => ['ru', 'Посмотреть видео', 'Наше производство'],
    'English homepage video' => ['en', 'Watch video', 'Our production'],
    'Uzbek homepage video' => ['uz', 'Videoni ko‘rish', 'Ishlab chiqarishimiz'],
]);

it('renders fabric samples in the selected language', function (string $locale, string $fabricLabel) {
    $response = $this->get(route('site.page', ['locale' => $locale, 'page' => 'products']));

    $response->assertOk()
        ->assertSee('data-product-gallery="fabric"', false)
        ->assertSee('gurlan-assets/products/fabric/1.jpg')
        ->assertSee($fabricLabel);
})->with([
    'Russian fabric catalog' => ['ru', '2 нитка'],
    'English fabric catalog' => ['en', '2-thread fabric'],
    'Uzbek fabric catalog' => ['uz', '2 ipli mato'],
]);

it('labels spinning, knitting and dyeing as production in every language', function (string $locale, array $productionLabels, array $departmentLabels) {
    $response = $this->get(route('site.page', ['locale' => $locale, 'page' => 'production']));

    $response->assertOk();

    foreach ($productionLabels as $label) {
        $response->assertSee($label);
    }

    foreach ($departmentLabels as $label) {
        $response->assertDontSee($label);
    }
})->with([
    'Russian production page' => [
        'ru',
        ['Прядильное производство', 'Вязальное производство', 'Красильное производство'],
        ['Прядильный цех', 'Вязальный цех', 'Красильный цех'],
    ],
    'English production page' => [
        'en',
        ['Spinning Production', 'Knitting Production', 'Dyeing Production'],
        ['Spinning Department', 'Knitting Department', 'Dyeing Department'],
    ],
    'Uzbek production page' => [
        'uz',
        ['Yigiruv ishlab chiqarishi', 'Trikotaj ishlab chiqarishi', 'Bo‘yash ishlab chiqarishi'],
        ['Yigiruv sexi', 'Trikotaj sexi', 'Bo‘yash sexi'],
    ],
]);

it('marks every production capacity value for count-up animation', function (string $locale, string $firstCapacity) {
    $response = $this->get(route('site.page', ['locale' => $locale, 'page' => 'production']));

    $response->assertOk()
        ->assertSee($firstCapacity)
        ->assertSee('data-count-up', false);

    expect(substr_count($response->getContent(), 'data-count-up'))->toBe(4);
})->with([
    'Russian production' => ['ru', '4 000'],
    'English production' => ['en', '4,000'],
    'Uzbek production' => ['uz', '4 000'],
]);

it('shows Uzbek as the selected language and preserves the current page in language links', function () {
    $response = $this->get('/uz/products');

    $response->assertOk()
        ->assertSee('<html lang="uz">', false)
        ->assertSee('lang="en"', false)
        ->assertSee('lang="ru"', false)
        ->assertSee(route('site.page', ['locale' => 'en', 'page' => 'products']), false)
        ->assertSee(route('site.page', ['locale' => 'ru', 'page' => 'products']), false);

    $selectedUzbekLink = '/<a\b(?=[^>]*href="[^"]*\/uz\/products")(?=[^>]*lang="uz")(?=[^>]*aria-current="page")[^>]*>/';

    expect(preg_match($selectedUzbekLink, $response->getContent()))->toBe(1);
});

it('returns 404 for unsupported languages and pages', function (string $path) {
    $response = $this->get($path);

    $response->assertNotFound();
})->with([
    'unsupported language' => ['/fr'],
    'unsupported page' => ['/ru/unsupported'],
]);

it('shows the Gurlan Global Teks location on the contact map', function () {
    $response = $this->get('/ru/contact');

    $response->assertOk()
        ->assertSee('marker=41.8263463%2C60.3761645', false)
        ->assertSee('destination=41.8263463%2C60.3761645', false)
        ->assertSee('Gurlan+Global+Teks/@41.8263463,60.3761645', false);
});
