@extends('admin.layouts.admin')

@section('title', $member->exists ? 'Изменить сотрудника' : 'Добавить сотрудника')
@section('content')
    <h1 class="text-3xl font-semibold">{{ $member->exists ? 'Изменить сотрудника' : 'Добавить сотрудника' }}</h1>
    <form class="mt-6 grid max-w-4xl gap-5 rounded-2xl bg-white p-6 shadow-sm" method="POST" enctype="multipart/form-data" action="{{ $member->exists ? route('admin.team.update', $member) : route('admin.team.store') }}">
        @csrf @if ($member->exists) @method('PUT') @endif
        @foreach (['ru' => 'Русский', 'en' => 'English', 'uz' => 'O‘zbek'] as $locale => $label)
            <fieldset class="grid gap-4 rounded-xl border border-stone-200 p-4 md:grid-cols-2"><legend class="px-2 font-medium">{{ $label }}</legend>
                <label class="grid gap-1 text-sm">Имя<input class="rounded-lg border border-stone-300 px-3 py-2" name="name_{{ $locale }}" value="{{ old('name_'.$locale, $member->{'name_'.$locale}) }}" required></label>
                <label class="grid gap-1 text-sm">Должность<input class="rounded-lg border border-stone-300 px-3 py-2" name="position_{{ $locale }}" value="{{ old('position_'.$locale, $member->{'position_'.$locale}) }}" required></label>
            </fieldset>
        @endforeach
        <label class="grid gap-1 text-sm">Фото<input class="rounded-xl border border-stone-300 px-3 py-2" type="file" name="image" accept="image/jpeg,image/png,image/webp" @required(! $member->exists)><small class="admin-field-help">Рекомендуется вертикальное портретное фото. Верхняя часть лица не обрезается.</small></label>
        <label class="grid gap-1 text-sm">Порядок<input class="rounded-xl border border-stone-300 px-3 py-2" type="number" min="0" name="sort_order" value="{{ old('sort_order', $member->sort_order ?? 0) }}" required></label>
        <button class="justify-self-start rounded-xl bg-emerald-700 px-5 py-3 font-medium text-white" type="submit">Сохранить</button>
    </form>
@endsection
