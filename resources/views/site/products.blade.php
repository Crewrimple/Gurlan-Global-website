@extends('layouts.site')

@section('title', $site->text($locale, 'common', 'products_title'))

@section('content')
    @php
        $english = $locale === 'en';
        $uzbek = $locale === 'uz';
        $uzumStoreUrl = $site->setting('uzum');
        $uzumShopLabel = $site->text($locale, 'products', 'store_label');
        $productGroups = ['women', 'men', 'fabric'];
    @endphp

    <section class="catalog-section">
        <div class="catalog-heading">
            <h1>{{ $site->text($locale, 'products', 'page_heading') }}</h1>
            <div class="catalog-tabs" role="tablist" aria-label="{{ $english ? 'Product categories' : ($uzbek ? 'Mahsulot toifalari' : 'Категории продукции') }}">
                <button type="button" class="is-active" role="tab" aria-selected="true" data-product-category="women">{{ $english ? 'Women' : ($uzbek ? 'Ayollar' : 'Женская') }}</button>
                <button type="button" role="tab" aria-selected="false" data-product-category="men">{{ $english ? 'Men' : ($uzbek ? 'Erkaklar' : 'Мужская') }}</button>
                <button type="button" role="tab" aria-selected="false" disabled>{{ $english ? 'Dyeing' : ($uzbek ? 'Bo‘yash' : 'Краска') }}</button>
                <button type="button" role="tab" aria-selected="false" data-product-category="fabric">{{ $english ? 'Fabric' : ($uzbek ? 'Mato' : 'Полотно') }}</button>
                <button type="button" role="tab" aria-selected="false" disabled>{{ $english ? 'Yarn' : ($uzbek ? 'Ip-kalava' : 'Пряжа') }}</button>
            </div>
        </div>

        <div class="catalog-store-action">
            <a class="solid-button catalog-store-button" href="{{ $uzumStoreUrl }}" target="_blank" rel="noopener noreferrer">
                {{ $uzumShopLabel }} <span aria-hidden="true">↗</span>
            </a>
        </div>

        @foreach ($productGroups as $category)
            @php($items = $cmsProducts->where('category', $category))
            <div class="catalog-grid" data-product-gallery="{{ $category }}" @if ($category !== 'women') hidden @endif>
                @forelse ($items as $product)
                    @php($imageUrl = str_starts_with($product->image_path, 'gurlan-assets/') ? asset($product->image_path) : asset('storage/'.$product->image_path))
                    <button class="catalog-item" type="button" data-catalog-image="{{ $imageUrl }}" aria-label="{{ $product->localized($locale, 'name') }}">
                        <img src="{{ $imageUrl }}" alt="{{ $product->localized($locale, 'name') }}" loading="{{ $loop->iteration <= 5 ? 'eager' : 'lazy' }}">
                        <span class="catalog-item-caption">
                            <strong>{{ $product->localized($locale, 'name') }}</strong>
                            @if ($product->localized($locale, 'description'))
                                <small>{{ $product->localized($locale, 'description') }}</small>
                            @endif
                            <b>{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }} / {{ str_pad((string) count($items), 2, '0', STR_PAD_LEFT) }}</b>
                        </span>
                    </button>
                @empty
                    <div class="catalog-empty">
                        <span aria-hidden="true">◇</span>
                        <p>{{ $english ? 'No products in this category yet.' : ($uzbek ? 'Bu toifada hali mahsulot yo‘q.' : 'В этой категории пока нет продукции.') }}</p>
                    </div>
                @endforelse
            </div>
        @endforeach
    </section>

    <div class="image-viewer" data-image-viewer hidden>
        <button class="image-viewer-backdrop" type="button" data-image-viewer-close aria-label="{{ $english ? 'Close image' : ($uzbek ? 'Rasmni yopish' : 'Закрыть изображение') }}"></button>
        <button class="image-viewer-close" type="button" data-image-viewer-close aria-label="{{ $english ? 'Close' : ($uzbek ? 'Yopish' : 'Закрыть') }}">×</button>
        <img alt="" data-image-viewer-image>
    </div>
@endsection
