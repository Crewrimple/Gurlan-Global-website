<?php

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;

it('renders the localized assistant on public pages', function () {
    $this->get('/uz')
        ->assertOk()
        ->assertSee('data-site-assistant', false)
        ->assertSee('GURLAN GLOBAL TEKS')
        ->assertSee('Bugun sizga qanday yordam bera olaman?')
        ->assertSee(route('site.assistant.store', ['locale' => 'uz']), false);
});

it('answers detailed company and partnership questions from local knowledge', function () {
    config()->set('services.openai.key', '');

    $this->postJson('/en/assistant', ['question' => 'Can you produce clothing for our private label?'])
        ->assertOk()
        ->assertJsonPath('answer', fn (string $answer): bool => str_contains($answer, 'private-label manufacturing'))
        ->assertJsonPath('answer', fn (string $answer): bool => str_contains($answer, 'quality control'));

    $this->postJson('/uz/assistant', ['question' => 'Buyurtma nechchi kunda tayyor bo‘ladi?'])
        ->assertOk()
        ->assertJsonPath('answer', fn (string $answer): bool => str_contains($answer, '7 kundan 35 ish kunigacha'));

    $this->postJson('/ru/assistant', ['question' => 'Расскажите подробнее о вашей компании'])
        ->assertOk()
        ->assertJsonPath('answer', fn (string $answer): bool => str_contains($answer, 'текстильный кластер полного цикла'))
        ->assertJsonPath('answer', fn (string $answer): bool => str_contains($answer, '2020 году'));

    $this->postJson('/ru/assistant', ['question' => 'Какая цена и минимальный заказ?'])
        ->assertOk()
        ->assertJsonPath('answer', fn (string $answer): bool => str_contains($answer, 'рассчитываются отдельно'));
});

it('returns a useful answer from site knowledge when no AI key is configured', function () {
    config()->set('services.openai.key', '');

    $this->postJson('/ru/assistant', ['question' => 'Как с вами связаться?'])
        ->assertOk()
        ->assertJsonPath('answer', fn (string $answer): bool => str_contains($answer, '+998 50 157 00 17'))
        ->assertJsonPath('answer', fn (string $answer): bool => str_contains($answer, 'gurlanglobal@gmail.com'));

    $this->postJson('/uz/assistant', ['question' => 'Qanday bog‘lanish mumkin?'])
        ->assertOk()
        ->assertJsonPath('answer', fn (string $answer): bool => str_contains($answer, '+998 50 157 00 17'))
        ->assertJsonPath('answer', fn (string $answer): bool => ! str_contains($answer, '127.0.0.1'))
        ->assertJsonPath('actions.0.label', 'Biz bilan bog‘laning');
});

it('asks the AI service with website context and returns its answer', function () {
    config()->set('services.openai.key', 'test-key');
    Http::preventStrayRequests();
    Http::fake([
        'https://api.openai.com/v1/responses' => Http::response([
            'output_text' => 'Annual capacity is up to 6,000,000 garments.',
        ]),
    ]);

    $this->postJson('/en/assistant', ['question' => 'What is the annual capacity?'])
        ->assertOk()
        ->assertJson(['answer' => 'Annual capacity is up to 6,000,000 garments.']);

    Http::assertSent(fn (Request $request): bool => $request->hasHeader('Authorization', 'Bearer test-key')
        && data_get($request->data(), 'model') === 'gpt-4.1-mini'
        && str_contains((string) data_get($request->data(), 'input'), 'What is the annual capacity?')
        && str_contains((string) data_get($request->data(), 'input'), '6,000,000'));
});

it('rejects invalid assistant questions', function () {
    $this->postJson('/uz/assistant', [])
        ->assertUnprocessable()
        ->assertJsonValidationErrors('question');

    $this->postJson('/uz/assistant', ['question' => str_repeat('a', 1001)])
        ->assertUnprocessable()
        ->assertJsonValidationErrors('question');
});

it('returns an explicit error when the AI service cannot be reached', function () {
    config()->set('services.openai.key', 'test-key');
    Http::preventStrayRequests();
    Http::fake([
        'https://api.openai.com/v1/responses' => Http::failedConnection(),
    ]);

    $this->postJson('/en/assistant', ['question' => 'What do you produce?'])
        ->assertStatus(502)
        ->assertJsonPath('message', 'The assistant is temporarily unavailable. Please try again later or contact us.');
});
