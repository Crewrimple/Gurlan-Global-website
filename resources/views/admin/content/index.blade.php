@extends('admin.layouts.admin')

@section('title', 'Тексты и SEO')
@section('content')
    @php
        $pageLabels = [
            'common' => 'Общее и SEO',
            'home' => 'Главная',
            'about' => 'О компании',
            'production' => 'Производство',
            'products' => 'Продукция',
            'contact' => 'Контакты',
            'news' => 'Новости',
        ];
        $languageLabels = ['ru' => 'Русский', 'en' => 'English', 'uz' => 'O‘zbek'];
    @endphp

    <div class="admin-page-header">
        <div>
            <p class="admin-kicker">Контент сайта</p>
            <h1>Тексты, меню и SEO</h1>
            <p class="admin-page-description">Редактируйте содержимое на трёх языках. После сохранения изменения сразу появляются на сайте.</p>
        </div>
        <span class="admin-language-summary"><b>3</b> языка</span>
    </div>

    <div class="admin-page-tabs admin-content-tabs">
        @foreach ($pages as $pageKey => $blocks)
            <a class="{{ $page === $pageKey ? 'is-active' : '' }}" href="{{ route('admin.content.index', ['page' => $pageKey]) }}">
                {{ $pageLabels[$pageKey] }}
                <span>{{ count($blocks) }}</span>
            </a>
        @endforeach
    </div>

    <div class="admin-content-intro">
        <div class="admin-content-intro-icon">Aa</div>
        <div>
            <strong>{{ $pageLabels[$page] }}</strong>
            <p>{{ count($pages[$page]) }} {{ trans_choice('блок|блока|блоков', count($pages[$page])) }} — заполните каждый язык одинаково понятно.</p>
        </div>
        <a href="{{ route('site.page', ['locale' => 'ru', 'page' => $page === 'home' ? null : ($page === 'common' ? null : $page)]) }}" target="_blank" rel="noopener">Посмотреть на сайте ↗</a>
    </div>

    <form class="admin-content-form" method="POST" action="{{ route('admin.content.update') }}">
        @csrf
        @method('PUT')

        @foreach ($pages[$page] as $key => $definition)
            <section class="admin-content-card">
                <div class="admin-content-card-heading">
                    <span class="admin-content-number">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                    <div>
                        <h2>{{ $definition['label'] }}</h2>
                        <p>Ключ блока: <code>{{ $key }}</code></p>
                    </div>
                </div>

                <div class="admin-translation-grid">
                    @foreach ($definition['values'] as $locale => $fallback)
                        @php($field = $stored->get($key.'|'.$locale))
                        @php($index = $loop->parent?->index * 3 + $loop->index)
                        <label class="admin-translation-field">
                            <span class="admin-language-label"><b>{{ strtoupper($locale) }}</b>{{ $languageLabels[$locale] }}</span>
                            <textarea name="blocks[{{ $index }}][value]" required>{{ old('blocks.'.$index.'.value', $field?->value ?? $fallback) }}</textarea>
                            <input type="hidden" name="blocks[{{ $index }}][page]" value="{{ $page }}">
                            <input type="hidden" name="blocks[{{ $index }}][key]" value="{{ $key }}">
                            <input type="hidden" name="blocks[{{ $index }}][locale]" value="{{ $locale }}">
                            <input type="hidden" name="blocks[{{ $index }}][label]" value="{{ $definition['label'] }}">
                        </label>
                    @endforeach
                </div>
            </section>
        @endforeach

        <div class="admin-content-savebar">
            <div><strong>{{ $pageLabels[$page] }}</strong><span>Все изменения сохраняются одновременно на RU, EN и UZ.</span></div>
            <button class="admin-primary-button" type="submit">Сохранить изменения</button>
        </div>
    </form>
@endsection
