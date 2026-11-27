<?php

use App\Models\ContentBlock;
use App\Models\NewsPost;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

it('requires an administrator to open the admin panel', function () {
    $this->get(route('admin.dashboard'))->assertRedirect(route('admin.login'));

    $this->actingAs(User::factory()->create())
        ->get(route('admin.dashboard'))
        ->assertForbidden();
});

it('renders every admin section for an administrator', function () {
    $admin = User::factory()->create(['is_admin' => true]);

    foreach ([
        route('admin.dashboard'),
        route('admin.content.index'),
        route('admin.products.index'),
        route('admin.products.create'),
        route('admin.news.index'),
        route('admin.news.create'),
        route('admin.team.index'),
        route('admin.team.create'),
        route('admin.media.index'),
        route('admin.settings.edit'),
        route('admin.messages.index'),
    ] as $url) {
        $this->actingAs($admin)->get($url)->assertOk();
    }
});

it('shows protected one-time administrator setup when no administrator exists', function () {
    config()->set('admin.setup_key', str_repeat('s', 32));

    $this->get(route('admin.login'))
        ->assertOk()
        ->assertSee('Создание единственного администратора')
        ->assertSee('setup_key');

    $this->post(route('admin.authenticate'), [
        'setup_key' => str_repeat('w', 32),
        'name' => 'Attempted Admin',
        'email' => 'other@example.com',
        'password' => 'StrongPassword1!@',
        'password_confirmation' => 'StrongPassword1!@',
    ])->assertForbidden();

    $this->assertDatabaseMissing('users', ['email' => 'other@example.com']);
});

it('creates exactly one administrator with the installation key', function () {
    $setupKey = str_repeat('s', 32);
    config()->set('admin.setup_key', $setupKey);

    $this->post(route('admin.authenticate'), [
        'setup_key' => $setupKey,
        'name' => 'Site Admin',
        'email' => 'admin@example.com',
        'password' => 'StrongPassword1!@',
        'password_confirmation' => 'StrongPassword1!@',
    ])->assertRedirect(route('admin.dashboard'));

    $this->assertDatabaseHas('users', [
        'email' => 'admin@example.com',
        'is_admin' => true,
    ]);
    expect(User::where('is_admin', true)->count())->toBe(1);

    $this->post(route('admin.logout'));
    $this->get(route('admin.login'))
        ->assertOk()
        ->assertDontSee('setup_key')
        ->assertSee('Вход в админ-панель');

    $this->post(route('admin.authenticate'), [
        'setup_key' => $setupKey,
        'name' => 'Second Admin',
        'email' => 'second@example.com',
        'password' => 'StrongPassword1!@',
        'password_confirmation' => 'StrongPassword1!@',
    ])->assertSessionHasErrors(['email']);

    expect(User::where('is_admin', true)->count())->toBe(1);
});

it('allows a 15 character password during the protected initial setup', function () {
    config()->set('admin.setup_key', str_repeat('s', 32));

    $this->post(route('admin.authenticate'), [
        'setup_key' => str_repeat('s', 32),
        'name' => 'Site Admin',
        'email' => 'admin@example.com',
        'password' => 'StrongPass123!@',
        'password_confirmation' => 'StrongPass123!@',
    ])->assertRedirect(route('admin.dashboard'));

    $this->assertDatabaseHas('users', [
        'email' => 'admin@example.com',
        'is_admin' => true,
    ]);
});

it('adds defensive headers to admin pages', function () {
    $this->get(route('admin.login'))
        ->assertHeader('X-Frame-Options', 'DENY')
        ->assertHeader('X-Content-Type-Options', 'nosniff')
        ->assertHeader('Referrer-Policy', 'no-referrer')
        ->assertHeader('X-Robots-Tag', 'noindex, nofollow')
        ->assertHeader('Cache-Control');
});

it('saves translated content and displays it publicly', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $payload = [
        [
            'page' => 'contact',
            'key' => 'page_heading',
            'locale' => 'ru',
            'label' => 'Заголовок страницы',
            'value' => 'НОВЫЙ ЗАГОЛОВОК',
        ],
    ];

    $this->actingAs($admin)
        ->put(route('admin.content.update'), ['blocks' => $payload])
        ->assertRedirect();

    expect(ContentBlock::where(['page' => 'contact', 'key' => 'page_heading', 'locale' => 'ru'])
        ->value('value'))->toBe('НОВЫЙ ЗАГОЛОВОК');

    $this->get('/ru/contact')->assertOk()->assertSee('НОВЫЙ ЗАГОЛОВОК');
});

it('uploads and stores a product for an administrator', function () {
    Storage::fake('public');
    $admin = User::factory()->create(['is_admin' => true]);

    $this->actingAs($admin)
        ->post(route('admin.products.store'), [
            'category' => 'fabric',
            'name_ru' => 'Новый материал',
            'name_en' => 'New material',
            'name_uz' => 'Yangi material',
            'description_ru' => 'Описание',
            'description_en' => 'Description',
            'description_uz' => 'Tavsif',
            'sort_order' => 20,
            'is_active' => 1,
            'image' => UploadedFile::fake()->createWithContent(
                'material.jpg',
                base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+A8AAQUBAScY42YAAAAASUVORK5CYII='),
            ),
        ])
        ->assertRedirect(route('admin.products.index'));

    $product = Product::where('name_ru', 'Новый материал')->firstOrFail();
    Storage::disk('public')->assertExists($product->image_path);
    $this->assertDatabaseHas('products', ['name_en' => 'New material', 'is_active' => true]);
});

it('stores a valid public contact request in the admin inbox', function () {
    $this->post(route('site.contact.store', ['locale' => 'ru']), [
        'name' => 'Контакт',
        'email' => 'contact@example.com',
        'country' => 'UZ',
        'phone' => '90 123 45 67',
        'message' => 'Нужна продукция',
        'consent' => '1',
        'website' => '',
    ])->assertRedirect(route('site.page', ['locale' => 'ru', 'page' => 'contact']));

    $this->assertDatabaseHas('contact_messages', [
        'email' => 'contact@example.com',
        'country_name' => 'Uzbekistan (Oʻzbekiston)',
        'phone' => '+998901234567',
        'is_read' => false,
    ]);
});

it('rejects a bot-filled contact request', function () {
    $this->post(route('site.contact.store', ['locale' => 'ru']), [
        'name' => 'Bot',
        'email' => 'bot@example.com',
        'country' => 'RU',
        'phone' => '+998901234567',
        'message' => 'Spam',
        'consent' => '1',
        'website' => 'spam.example',
    ])->assertSessionHasErrors(['website']);

    $this->assertDatabaseMissing('contact_messages', ['email' => 'bot@example.com']);
});

it('renders news as an ordered card grid', function () {
    NewsPost::create([
        'title_ru' => 'Старая новость',
        'title_en' => 'Older news',
        'title_uz' => 'Eski yangilik',
        'summary_ru' => 'Старое описание',
        'summary_en' => 'Older summary',
        'summary_uz' => 'Eski tavsif',
        'body_ru' => 'Старый текст',
        'body_en' => 'Older body',
        'body_uz' => 'Eski matn',
        'published_at' => now()->subDay(),
    ]);
    NewsPost::create([
        'title_ru' => 'Новая новость',
        'title_en' => 'Latest news',
        'title_uz' => 'Yangi yangilik',
        'summary_ru' => 'Новое описание',
        'summary_en' => 'Latest summary',
        'summary_uz' => 'Yangi tavsif',
        'body_ru' => 'Новый текст',
        'body_en' => 'Latest body',
        'body_uz' => 'Yangi matn',
        'published_at' => now(),
    ]);

    $response = $this->get('/ru/news');

    $response->assertOk()
        ->assertSee('class="news-grid"', false)
        ->assertSeeInOrder(['Новая новость', 'Старая новость'])
        ->assertSee('Читать полностью');
});

it('shows editable product names and a safe caption in the public catalog', function () {
    Product::create([
        'category' => 'women',
        'name_ru' => str_repeat('Очень длинное название продукта ', 8),
        'name_en' => 'Long product name',
        'name_uz' => 'Uzun mahsulot nomi',
        'description_ru' => 'Описание товара',
        'description_en' => 'Product description',
        'description_uz' => 'Mahsulot tavsifi',
        'image_path' => 'gurlan-assets/products/women/1.jpg',
        'sort_order' => 0,
        'is_active' => true,
    ]);

    $this->get('/ru/products')
        ->assertOk()
        ->assertSee('Очень длинное название продукта')
        ->assertSee('catalog-item-caption', false)
        ->assertSee('Описание товара');
});

it('renders a graceful empty state for a product category', function () {
    Product::query()->where('category', 'fabric')->delete();

    $this->get('/ru/products')
        ->assertOk()
        ->assertSee('В этой категории пока нет продукции.')
        ->assertSee('catalog-empty', false);
});

it('keeps the existing public layout for long CMS titles and descriptions', function () {
    ContentBlock::updateOrCreate(
        ['page' => 'home', 'key' => 'hero_title', 'locale' => 'ru'],
        ['label' => 'Заголовок первого экрана', 'value' => str_repeat('Очень длинный заголовок ', 12)],
    );
    ContentBlock::updateOrCreate(
        ['page' => 'home', 'key' => 'indicators_intro_1', 'locale' => 'ru'],
        ['label' => 'Вступление', 'value' => str_repeat('Длинный текст без нарушения структуры страницы. ', 20)],
    );

    $this->get('/ru')
        ->assertOk()
        ->assertSee('Очень длинный заголовок')
        ->assertSee('Длинный текст без нарушения структуры страницы.')
        ->assertSee('home-hero-copy', false)
        ->assertSee('indicator-intro', false);
});

it('keeps the administrator in the news section after deleting a post', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $post = NewsPost::create([
        'title_ru' => 'Удаляемая',
        'title_en' => 'Delete me',
        'title_uz' => 'O‘chiriladi',
        'summary_ru' => '',
        'summary_en' => '',
        'summary_uz' => '',
        'body_ru' => 'Текст',
        'body_en' => 'Body',
        'body_uz' => 'Matn',
        'published_at' => now(),
    ]);

    $this->actingAs($admin)
        ->delete(route('admin.news.destroy', $post))
        ->assertRedirect(route('admin.news.index'));

    $this->assertAuthenticatedAs($admin);
    $this->assertDatabaseMissing('news_posts', ['id' => $post->id]);
});
