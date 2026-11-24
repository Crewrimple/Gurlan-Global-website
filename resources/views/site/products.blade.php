@extends('layouts.site')

@section('title', $locale === 'en' ? 'Products - Gurlan Global Teks' : ($locale === 'uz' ? 'Mahsulotlar - Gurlan Global Teks' : 'Продукция - Gurlan Global Teks'))

@section('content')
    @php
        $english = $locale === 'en';
        $uzbek = $locale === 'uz';
        $uzumStoreUrl = 'https://uzum.uz/ru/shop/gurlanglobal';
        $uzumShopLabel = $english ? 'Shop on the Uzum marketplace' : ($uzbek ? 'Uzum marketpleysida xarid qilish' : 'Купить на маркетплейсе Uzum');
        $productGroups = [
            'women' => range(1, 15),
            'men' => range(1, 14),
            'fabric' => range(1, 9),
        ];
        $fabricNames = $uzbek
            ? ['2 ipli mato', '3 ipli mato', 'Kulirka', 'Velur', 'Interlok', 'Kashkorse', 'Mahra', 'Pike', 'Suprem']
            : ($english
                ? ['2-thread fabric', '3-thread fabric', 'Single jersey', 'Velour', 'Interlock', 'Rib knit', 'Terry', 'Piqué', 'Suprem knit']
                : ['2 нитка', '3 нитка', 'Кулирка', 'Велюр', 'Интерлок', 'Кашкорсе', 'Махра', 'Пике', 'Супрем']);
    @endphp

    <section class="catalog-section">
        <div class="catalog-heading">
            <h1>{{ $english ? 'PRODUCT RANGE' : ($uzbek ? 'MAHSULOTLAR ASSORTIMENTI' : 'АССОРТИМЕНТ ПРОДУКЦИИ') }}</h1>
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

        @foreach ($productGroups as $category => $items)
            <div class="catalog-grid" data-product-gallery="{{ $category }}" @if ($category !== 'women') hidden @endif>
                @foreach ($items as $index)
                    @php
                        $itemName = $category === 'fabric' ? $fabricNames[$index - 1] : null;
                    @endphp
                    <button class="catalog-item" type="button" data-catalog-image="{{ asset('gurlan-assets/products/'.$category.'/'.$index.'.jpg') }}" aria-label="{{ $itemName ? ($english ? 'Fabric: ' : ($uzbek ? 'Mato: ' : 'Полотно: ')).$itemName : ($english ? 'View product ' : ($uzbek ? 'Mahsulotni ko‘rish ' : 'Посмотреть изделие ')).$index }}">
                        <img src="{{ asset('gurlan-assets/products/'.$category.'/'.$index.'.jpg') }}" alt="{{ $itemName ?? '' }}" loading="{{ $index <= 5 ? 'eager' : 'lazy' }}">
                        <span>{{ $itemName ?? str_pad((string) $index, 2, '0', STR_PAD_LEFT).' / '.str_pad((string) count($items), 2, '0', STR_PAD_LEFT) }}</span>
                    </button>
                @endforeach
            </div>
        @endforeach
    </section>

    <div class="image-viewer" data-image-viewer hidden>
        <button class="image-viewer-backdrop" type="button" data-image-viewer-close aria-label="{{ $english ? 'Close image' : ($uzbek ? 'Rasmni yopish' : 'Закрыть изображение') }}"></button>
        <button class="image-viewer-close" type="button" data-image-viewer-close aria-label="{{ $english ? 'Close' : ($uzbek ? 'Yopish' : 'Закрыть') }}">×</button>
        <img alt="" data-image-viewer-image>
    </div>
@endsection
