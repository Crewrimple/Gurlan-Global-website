@extends('admin.layouts.admin')

@section('title', $product->exists ? 'Изменить продукт' : 'Добавить продукт')
@section('content')
    <div class="admin-page-header">
        <div>
            <p class="admin-kicker">Каталог сайта</p>
            <h1>{{ $product->exists ? 'Изменить продукт' : 'Новый продукт' }}</h1>
            <p class="admin-page-description">Заполните данные на трёх языках. На сайте карточка сохранит единый размер и стиль.</p>
        </div>
        <a class="admin-secondary-button" href="{{ route('admin.products.index') }}">← К списку</a>
    </div>

    <form class="admin-editor-layout" method="POST" enctype="multipart/form-data" action="{{ $product->exists ? route('admin.products.update', $product) : route('admin.products.store') }}">
        @csrf
        @if ($product->exists) @method('PUT') @endif
        <div class="admin-editor-main">
            <section class="admin-panel-card">
                <div class="admin-panel-heading"><span>01</span><div><h2>Названия и описание</h2><p>Каждый язык отображается на соответствующей версии сайта.</p></div></div>
                <div class="admin-language-fields">
                    @foreach (['ru' => 'Русский', 'en' => 'English', 'uz' => 'O‘zbek'] as $locale => $label)
                        <fieldset class="admin-language-card">
                            <legend>{{ $label }}</legend>
                            <label>Название<input name="name_{{ $locale }}" value="{{ old('name_'.$locale, $product->{'name_'.$locale}) }}" maxlength="255" required></label>
                            <label>Описание<textarea name="description_{{ $locale }}" rows="4" maxlength="3000">{{ old('description_'.$locale, $product->{'description_'.$locale}) }}</textarea></label>
                        </fieldset>
                    @endforeach
                </div>
            </section>

            <section class="admin-panel-card">
                <div class="admin-panel-heading"><span>02</span><div><h2>Настройки публикации</h2><p>Категория определяет вкладку, в которой появится товар.</p></div></div>
                <div class="admin-settings-grid">
                    <label>Категория
                        <select name="category" required>
                            @foreach (['women' => 'Женская', 'men' => 'Мужская', 'fabric' => 'Полотно'] as $value => $label)
                                <option value="{{ $value }}" @selected(old('category', $product->category) === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label>Порядок сортировки<input type="number" min="0" max="9999" name="sort_order" value="{{ old('sort_order', $product->sort_order ?? 0) }}" required><small class="admin-field-help">Меньшее число показывается выше.</small></label>
                </div>
                <label class="admin-switch-row">
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $product->exists ? $product->is_active : true))>
                    <span><strong>Показывать на сайте</strong><small>Отключите, чтобы временно скрыть продукт.</small></span>
                </label>
            </section>
        </div>

        <aside class="admin-editor-side">
            <section class="admin-panel-card admin-image-editor">
                <div class="admin-panel-heading"><span>03</span><div><h2>Фотография</h2><p>Вертикальное изображение.</p></div></div>
                <div class="admin-product-preview">
                    @if ($product->exists)
                        <img src="{{ str_starts_with($product->image_path, 'gurlan-assets/') ? asset($product->image_path) : asset('storage/'.$product->image_path) }}" alt="{{ $product->name_ru }}">
                    @else
                        <div><span>＋</span><small>Предпросмотр фото</small></div>
                    @endif
                </div>
                <label class="admin-upload-field">
                    <input type="file" name="image" accept="image/jpeg,image/png,image/webp" @required(! $product->exists)>
                    <span>Выбрать фотографию</span>
                </label>
                <small class="admin-field-help">JPG, PNG или WebP до 8 МБ. Рекомендуется 800×1100 px или больше.</small>
            </section>
            <div class="admin-editor-actions">
                <button class="admin-primary-button" type="submit">Сохранить продукт</button>
                <a class="admin-secondary-button" href="{{ route('admin.products.index') }}">Отмена</a>
            </div>
        </aside>
    </form>
@endsection
