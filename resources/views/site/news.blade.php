@extends('layouts.site')

@section('title', $locale === 'en' ? 'News - Gurlan Global Teks' : ($locale === 'uz' ? 'Yangiliklar - Gurlan Global Teks' : 'Новости - Gurlan Global Teks'))

@section('content')
    <section class="news-section">
        <div class="section-shell">
            <h1>{{ $locale === 'en' ? 'NEWS' : ($locale === 'uz' ? 'YANGILIKLAR' : 'НОВОСТИ') }}</h1>
            <p>{{ $locale === 'en' ? 'No news yet.' : ($locale === 'uz' ? 'Hozircha yangiliklar yo‘q.' : 'Новостей пока нет.') }}</p>
        </div>
    </section>
@endsection
