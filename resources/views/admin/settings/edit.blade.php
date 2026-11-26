@extends('admin.layouts.admin')

@section('title', 'Контакты и настройки')
@section('content')
    <h1 class="text-3xl font-semibold">Контакты и настройки</h1>
    <form class="mt-6 grid max-w-3xl gap-4 rounded-2xl bg-white p-6 shadow-sm" method="POST" action="{{ route('admin.settings.update') }}">
        @csrf @method('PUT')
        @foreach ($definitions as $key => $definition)
            <label class="grid gap-1 text-sm font-medium">{{ $definition['label'] }}<textarea class="min-h-12 rounded-xl border border-stone-300 px-3 py-2 font-normal" name="settings[{{ $key }}]" required>{{ old('settings.'.$key, $settings->get($key, $definition['value'])) }}</textarea></label>
        @endforeach
        <button class="justify-self-start rounded-xl bg-emerald-700 px-5 py-3 font-medium text-white" type="submit">Сохранить настройки</button>
    </form>
@endsection
