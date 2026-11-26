@extends('admin.layouts.admin')

@section('title', 'Продукция')
@section('content')
    <div class="admin-page-header">
        <div>
            <p class="admin-kicker">Каталог сайта</p>
            <h1>Продукция</h1>
            <p class="admin-page-description">Управляйте фотографиями, названиями, категориями и порядком товаров на сайте.</p>
        </div>
        <a class="admin-primary-button" href="{{ route('admin.products.create') }}"><span aria-hidden="true">＋</span> Добавить продукт</a>
    </div>

    <div class="admin-mini-stats">
        <div><span>Все товары</span><strong>{{ $totalProducts }}</strong></div>
        <div><span>На сайте</span><strong>{{ $activeProducts }}</strong></div>
        <div><span>Скрыто</span><strong>{{ $hiddenProducts }}</strong></div>
    </div>

    <form class="admin-filter-bar" method="GET" action="{{ route('admin.products.index') }}">
        <label class="admin-search-field">
            <span aria-hidden="true">⌕</span>
            <input type="search" name="search" value="{{ request('search') }}" placeholder="Поиск по названию RU / EN / UZ">
        </label>
        <select name="category" aria-label="Категория">
            <option value="">Все категории</option>
            @foreach (['women' => 'Женская', 'men' => 'Мужская', 'fabric' => 'Полотно'] as $value => $label)
                <option value="{{ $value }}" @selected(request('category') === $value)>{{ $label }}</option>
            @endforeach
        </select>
        <select name="status" aria-label="Статус">
            <option value="">Любой статус</option>
            <option value="active" @selected(request('status') === 'active')>Опубликован</option>
            <option value="hidden" @selected(request('status') === 'hidden')>Скрыт</option>
        </select>
        <button class="admin-filter-button" type="submit">Применить</button>
        @if (request()->hasAny(['search', 'category', 'status']))
            <a class="admin-clear-filter" href="{{ route('admin.products.index') }}">Сбросить</a>
        @endif
    </form>

    <div class="admin-product-table-card">
        <div class="admin-table-scroll">
            <table class="admin-product-table">
                <thead><tr><th>Продукт</th><th>Категория</th><th>Порядок</th><th>Статус</th><th><span class="sr-only">Действия</span></th></tr></thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td>
                                <div class="admin-product-cell">
                                    <img src="{{ str_starts_with($product->image_path, 'gurlan-assets/') ? asset($product->image_path) : asset('storage/'.$product->image_path) }}" alt="{{ $product->name_ru }}">
                                    <div><strong>{{ $product->name_ru }}</strong><span>{{ $product->name_en }}</span></div>
                                </div>
                            </td>
                            <td><span class="admin-category-pill">{{ ['women' => 'Женская', 'men' => 'Мужская', 'fabric' => 'Полотно'][$product->category] }}</span></td>
                            <td><span class="admin-order-value">{{ $product->sort_order }}</span></td>
                            <td><span class="admin-status-pill {{ $product->is_active ? 'is-active' : 'is-hidden' }}"><i></i>{{ $product->is_active ? 'На сайте' : 'Скрыт' }}</span></td>
                            <td>
                                <div class="admin-row-actions">
                                    <a href="{{ route('admin.products.edit', $product) }}">Изменить</a>
                                    <form class="admin-action-form" method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Удалить продукт?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" aria-label="Удалить {{ $product->name_ru }}">Удалить</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5"><div class="admin-table-empty"><span>◇</span><strong>Продукты не найдены</strong><p>Измените фильтры или добавьте первый продукт.</p></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="admin-pagination">{{ $products->links() }}</div>
@endsection
