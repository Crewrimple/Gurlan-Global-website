@extends('admin.layouts.admin')

@section('title', 'Фото и видео')
@section('content')
    @php
        $mediaTips = [
            'logo' => ['type' => 'Логотип', 'size' => '104 × 44 px на сайте', 'upload' => '600 × 250 px или больше', 'ratio' => 'Горизонтальный · PNG с прозрачностью'],
            'home_hero_1' => ['type' => 'Главный слайд', 'size' => 'На весь экран', 'upload' => '1920 × 1080 px', 'ratio' => '16:9 · горизонтально'],
            'home_hero_2' => ['type' => 'Главный слайд', 'size' => 'На весь экран', 'upload' => '1920 × 1080 px', 'ratio' => '16:9 · горизонтально'],
            'home_video' => ['type' => 'Видео', 'size' => 'Окно плеера', 'upload' => '1920 × 1080 px / MP4', 'ratio' => '16:9 или ссылка YouTube'],
            'about_hero' => ['type' => 'Обложка страницы', 'size' => 'Ширина страницы', 'upload' => '1920 × 650 px', 'ratio' => 'Около 3:1'],
            'production_hero' => ['type' => 'Обложка страницы', 'size' => 'Ширина страницы', 'upload' => '1920 × 650 px', 'ratio' => 'Около 3:1'],
            'home_why' => ['type' => 'Фото раздела', 'size' => 'Правая половина блока', 'upload' => '1200 × 1200 px', 'ratio' => '1:1 или 4:3'],
            'about_history' => ['type' => 'Фото раздела', 'size' => 'Правая колонка', 'upload' => '1200 × 1000 px', 'ratio' => 'Около 6:5'],
            'about_sustainability' => ['type' => 'Фоновое фото', 'size' => 'На всю ширину', 'upload' => '1920 × 1080 px', 'ratio' => '16:9'],
            'production_capacity' => ['type' => 'Фото раздела', 'size' => 'Правая половина блока', 'upload' => '1200 × 900 px', 'ratio' => '4:3'],
        ];
    @endphp

    <div class="admin-page-header">
        <div>
            <p class="admin-kicker">Визуальный контент</p>
            <h1>Фотографии и видео</h1>
            <p class="admin-page-description">Каждое изображение привязано к конкретному месту сайта. Используйте рекомендуемый размер, чтобы сохранить исходный дизайн.</p>
        </div>
        <span class="admin-language-summary"><b>{{ count($definitions) }}</b> медиа-блоков</span>
    </div>

    <div class="admin-media-grid">
        @foreach ($definitions as $key => $definition)
            @php
                $asset = $assets->get($key);
                $path = $asset?->file_path ?? $definition['path'];
                $url = str_starts_with($path, 'http') ? $path : (str_starts_with($path, 'gurlan-assets/') ? asset($path) : asset('storage/'.$path));
                $tip = $mediaTips[$key] ?? ['type' => 'Изображение', 'size' => 'Адаптивный блок', 'upload' => '1600 × 1000 px', 'ratio' => 'Горизонтально'];
                $isVideo = $key === 'home_video';
            @endphp
            <form class="admin-media-card {{ $isVideo ? 'is-video' : '' }}" method="POST" enctype="multipart/form-data" action="{{ route('admin.media.update', $key) }}">
                @csrf
                @method('PUT')

                <div class="admin-media-preview {{ $key === 'logo' ? 'is-logo' : '' }}">
                    @if ($isVideo)
                        <div class="admin-video-preview"><span aria-hidden="true">▶</span><small>Видео главного экрана</small></div>
                    @else
                        <img src="{{ $url }}" alt="{{ $definition['label'] }}">
                    @endif
                    <span class="admin-media-kind">{{ $tip['type'] }}</span>
                </div>

                <div class="admin-media-copy">
                    <div class="admin-media-title">
                        <div><h2>{{ $definition['label'] }}</h2><p>На сайте: {{ $tip['size'] }}</p></div>
                        <span>{{ $loop->iteration }}</span>
                    </div>

                    <div class="admin-size-guide">
                        <div><span>Рекомендуемый файл</span><strong>{{ $tip['upload'] }}</strong></div>
                        <div><span>Формат и пропорция</span><strong>{{ $tip['ratio'] }}</strong></div>
                    </div>

                    <label class="admin-media-upload">
                        <span>Загрузить {{ $isVideo ? 'видео' : 'изображение' }}</span>
                        <input type="file" name="file" accept="{{ $isVideo ? 'video/mp4,video/webm' : 'image/jpeg,image/png,image/webp' }}">
                    </label>

                    <label class="admin-media-url">
                        <span>{{ $isVideo ? 'Или ссылка на видео / YouTube embed' : 'Или внешняя ссылка на файл' }}</span>
                        <input type="url" name="url" value="{{ str_starts_with($path, 'http') ? $path : '' }}" placeholder="https://...">
                    </label>

                    <div class="admin-media-footer">
                        <small>{{ $isVideo ? 'MP4, WebM или embed-ссылка до 50 МБ.' : 'JPG, PNG или WebP. Максимум 50 МБ.' }}</small>
                        <button class="admin-primary-button" type="submit">Сохранить</button>
                    </div>
                </div>
            </form>
        @endforeach
    </div>
@endsection
