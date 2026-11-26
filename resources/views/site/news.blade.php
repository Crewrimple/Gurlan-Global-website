@extends('layouts.site')

@section('title', $site->text($locale, 'common', 'news_title'))

@section('content')
    <section class="news-section">
        <div class="section-shell">
            <div class="news-heading">
                <div>
                    <p class="eyebrow">{{ $locale === 'en' ? 'COMPANY EVENTS' : ($locale === 'uz' ? 'KOMPANIYA YANGILIKLARI' : 'СОБЫТИЯ КОМПАНИИ') }}</p>
                    <h1>{{ $site->text($locale, 'news', 'page_heading') }}</h1>
                </div>
                <p>{{ $locale === 'en' ? 'Latest company news, production developments and important events.' : ($locale === 'uz' ? 'Kompaniya yangiliklari, ishlab chiqarish va muhim voqealar.' : 'Актуальные события компании, развитие производства и важные объявления.') }}</p>
            </div>

            <div class="news-grid">
                @forelse ($cmsNews as $post)
                    <article class="news-card {{ $loop->first ? 'is-featured' : '' }} {{ $post->image_path ? '' : 'has-no-image' }}">
                        @if ($post->image_path)
                            <div class="news-card-image">
                                <img src="{{ asset('storage/'.$post->image_path) }}" alt="{{ $post->localized($locale, 'title') }}" loading="{{ $loop->first ? 'eager' : 'lazy' }}">
                            </div>
                        @else
                            <div class="news-card-image news-card-placeholder" aria-hidden="true">
                                <span>GURLAN</span>
                            </div>
                        @endif
                        <div class="news-card-copy">
                            <time datetime="{{ $post->published_at->toIso8601String() }}">{{ $post->published_at->translatedFormat('d F Y') }}</time>
                            <h2>{{ $post->localized($locale, 'title') }}</h2>
                            @if ($post->localized($locale, 'summary'))
                                <p>{{ $post->localized($locale, 'summary') }}</p>
                            @endif
                            <details class="news-card-details">
                                <summary>
                                    {{ $locale === 'en' ? 'Read more' : ($locale === 'uz' ? 'Batafsil o‘qish' : 'Читать полностью') }}
                                    <span aria-hidden="true">↗</span>
                                </summary>
                                <div>{!! nl2br(e($post->localized($locale, 'body'))) !!}</div>
                            </details>
                        </div>
                    </article>
                @empty
                    <div class="news-empty">
                        <span aria-hidden="true">▤</span>
                        <h2>{{ $site->text($locale, 'news', 'empty') }}</h2>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
