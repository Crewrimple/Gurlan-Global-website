@extends('admin.layouts.admin')

@section('title', $post->exists ? 'Изменить новость' : 'Добавить новость')
@section('content')
    <h1 class="text-3xl font-semibold">{{ $post->exists ? 'Изменить новость' : 'Добавить новость' }}</h1>
    <form class="mt-6 grid max-w-5xl gap-5 rounded-2xl bg-white p-6 shadow-sm" method="POST" enctype="multipart/form-data" action="{{ $post->exists ? route('admin.news.update', $post) : route('admin.news.store') }}">
        @csrf @if ($post->exists) @method('PUT') @endif
        @foreach (['ru' => 'Русский', 'en' => 'English', 'uz' => 'O‘zbek'] as $locale => $label)
            <fieldset class="grid gap-4 rounded-xl border border-stone-200 p-4"><legend class="px-2 font-medium">{{ $label }}</legend>
                <label class="grid gap-1 text-sm">Заголовок<input class="rounded-lg border border-stone-300 px-3 py-2" name="title_{{ $locale }}" value="{{ old('title_'.$locale, $post->{'title_'.$locale}) }}" required></label>
                <label class="grid gap-1 text-sm">Краткое описание<textarea class="min-h-20 rounded-lg border border-stone-300 px-3 py-2" name="summary_{{ $locale }}">{{ old('summary_'.$locale, $post->{'summary_'.$locale}) }}</textarea></label>
                <label class="grid gap-1 text-sm">Полный текст<textarea class="min-h-40 rounded-lg border border-stone-300 px-3 py-2" name="body_{{ $locale }}" required>{{ old('body_'.$locale, $post->{'body_'.$locale}) }}</textarea></label>
            </fieldset>
        @endforeach
        <label class="grid gap-1 text-sm">Изображение<input class="rounded-xl border border-stone-300 px-3 py-2" type="file" name="image" accept="image/jpeg,image/png,image/webp"><small class="admin-field-help">Рекомендуется горизонтальное фото 16:9, например 1600×900 px.</small></label>
        <div class="grid gap-4 sm:grid-cols-2"><label class="flex items-center gap-2 text-sm"><input type="checkbox" name="is_published" value="1" @checked(old('is_published', (bool) $post->published_at))>Опубликовать</label><label class="grid gap-1 text-sm">Дата публикации<input class="rounded-xl border border-stone-300 px-3 py-2" type="datetime-local" name="published_at" value="{{ old('published_at', $post->published_at?->format('Y-m-d\TH:i') ?? now()->format('Y-m-d\TH:i')) }}"></label></div>
        <button class="justify-self-start rounded-xl bg-emerald-700 px-5 py-3 font-medium text-white" type="submit">Сохранить</button>
    </form>
@endsection
