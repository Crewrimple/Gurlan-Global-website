@extends('admin.layouts.admin')

@section('title', 'Новости')
@section('content')
    <div class="flex items-center justify-between gap-4"><h1 class="text-3xl font-semibold">Новости</h1><a class="rounded-xl bg-emerald-700 px-4 py-2 text-sm font-medium text-white" href="{{ route('admin.news.create') }}">Добавить новость</a></div>
    <div class="mt-6 grid gap-4">
        @forelse ($posts as $post)
            <article class="rounded-2xl border border-stone-200 bg-white p-5">
                <div class="flex flex-wrap justify-between gap-4"><div><h2 class="text-xl font-semibold">{{ $post->title_ru }}</h2><p class="mt-1 text-sm text-stone-500">{{ $post->published_at ? 'Опубликовано '.$post->published_at->format('d.m.Y H:i') : 'Черновик' }}</p></div><div class="admin-card-actions"><a class="admin-action-button" href="{{ route('admin.news.edit', $post) }}">Изменить</a><form class="admin-action-form" method="POST" action="{{ route('admin.news.destroy', $post) }}" onsubmit="return confirm('Удалить новость?')">@csrf @method('DELETE')<button class="admin-action-button is-danger" type="submit">Удалить</button></form></div></div>
            </article>
        @empty
            <p class="rounded-2xl bg-white p-6 text-stone-500">Новостей пока нет.</p>
        @endforelse
    </div>
    <div class="mt-5">{{ $posts->links() }}</div>
@endsection
